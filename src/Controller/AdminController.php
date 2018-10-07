<?php

namespace App\Controller;

use App\Entity\Common\{Role,User};
use App\Form\RoleType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/role", name="role-list")
     */
    public function roleList() {

        $roles = $this->getDoctrine()->getRepository(Role::class)->findAll();

        return $this->render('admin/role-list.html.twig', [
            'roles' => $roles
        ]);
    }

    /**
     * @Route("/admin/view/{id}", name="role-view")
     */
    public function roleView() {

    }

    /**
     * @Route("/admin/role/new", name="role-new")
     */
    public function createRole(Request $request) {

        $role = new Role();
        $role->setName('');
        $role->setDescription('');

        //$form = $this->createFormBuilder($role)->getForm();
        $form = $this->createForm(RoleType::class, $role);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $role = $form->getData();
            $role->setCreatedAt((new \DateTime()));
            $role->setUpdatedAt((new \DateTime()));

            $entityManager =  $this->getDoctrine()->getManager();
            $entityManager->persist($role);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/role-new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/user", name="user-list")
     */
    public function userList(Request $request) {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('admin/user-list.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/admin/user/view/{id}", name="user-view")
     */
    public function userView(Request $request, $id, UserPasswordEncoderInterface $encoder) {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        if (!$user) {
            throw new NotFoundHttpException('Пользователь не найден');
        }

        if ($request->isXmlHttpRequest()) {
            $data = $_POST;
            /*if (in_array('password', $data)) {
                $data['password'] = $encoder->encodePassword($user, $data['password']);
            }*/
            //$old_password = $user->getPassword();
            //$user->load($data);
            //$manager = $this->getDoctrine()->getManager();
            //$manager->persist($user);
            //$manager->flush();

            $result = $this->getDoctrine()->getRepository(User::class)->update($user, $data);

            return new JsonResponse([
                'id' => $user->getId(),
                'message' => 'Пользователь изменен',
                'result' => $result
                //'src' => $data['password'],
                //'enc' => $encoder->encodePassword($user, $data['password'])
            ]);
        }

        return $this->render('admin/user-view.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/admin/user/new", name="user-new", methods={"GET", "POST"})
     */
    public function createUser(Request $request) {

        if ($request->isXmlHttpRequest()) {

            $response_array = [
                'error' => 0,
            ];
            $result = $this->getDoctrine()->getRepository(User::class)->create($_POST);
            if ($result) {
                $response_array['redirect_url'] = '/admin/user';
            } else {
                $response_array['error'] = 1;
                $response_array['message'] = 'Не удалось создать пользователя';
            }

            //return $this->redirectToRoute('user-list');
            return new Response(json_encode($response_array));
        }

        $roles = $this->getDoctrine()->getRepository(Role::class)->findAll();

        return $this->render('admin/user-new.html.twig',[
            'roles' => $roles
        ]);
    }


}
