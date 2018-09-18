<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Form\RoleType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/admin/role/new", name="role_new")
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
     * @Route("/admin/user/new", name="user_new")
     */
    public function createUser(Request $request) {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $user->setCreatedAt((new \DateTime()));
            $user->setUpdatedAt((new \DateTime()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

        }
        return $this->render('admin/user-new.html.twig',[
            'form' => $form->createView()
        ]);
    }


}
