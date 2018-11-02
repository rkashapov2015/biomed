<?php

namespace App\Controller\Common;

use App\Entity\Common\CommonParam;
use App\Form\Common\CommonParamType;
use App\Repository\CommonParamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/common/common/param")
 */
class CommonParamController extends AbstractController
{
    /**
     * @Route("/", name="common_common_param_index", methods="GET")
     */
    public function index(CommonParamRepository $commonParamRepository): Response
    {
        return $this->render('common_common_param/index.html.twig', ['common_params' => $commonParamRepository->findAll()]);
    }

    /**
     * @Route("/new", name="common_common_param_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $commonParam = new CommonParam();
        $form = $this->createForm(CommonParamType::class, $commonParam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commonParam);
            $em->flush();

            return $this->redirectToRoute('common_common_param_index');
        }

        return $this->render('common_common_param/new.html.twig', [
            'common_param' => $commonParam,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="common_common_param_show", methods="GET")
     */
    public function show(CommonParam $commonParam): Response
    {
        return $this->render('common_common_param/show.html.twig', ['common_param' => $commonParam]);
    }

    /**
     * @Route("/{id}/edit", name="common_common_param_edit", methods="GET|POST")
     */
    public function edit(Request $request, CommonParam $commonParam): Response
    {
        $form = $this->createForm(CommonParamType::class, $commonParam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('common_common_param_edit', ['id' => $commonParam->getId()]);
        }

        return $this->render('common_common_param/edit.html.twig', [
            'common_param' => $commonParam,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="common_common_param_delete", methods="DELETE")
     */
    public function delete(Request $request, CommonParam $commonParam): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commonParam->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commonParam);
            $em->flush();
        }

        return $this->redirectToRoute('common_common_param_index');
    }
}
