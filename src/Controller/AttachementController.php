<?php

namespace App\Controller;

use App\Entity\Attachement;
use App\Form\AttachementType;
use App\Repository\AttachementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/attachement")
 */
class AttachementController extends AbstractController
{
    /**
     * @Route("/", name="app_attachement_index", methods={"GET"})
     */
    public function index(AttachementRepository $attachementRepository): Response
    {
        return $this->render('attachement/index.html.twig', [
            'attachements' => $attachementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_attachement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AttachementRepository $attachementRepository): Response
    {
        $attachement = new Attachement();
        $form = $this->createForm(AttachementType::class, $attachement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attachementRepository->add($attachement);
            return $this->redirectToRoute('app_attachement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('attachement/new.html.twig', [
            'attachement' => $attachement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_attachement_show", methods={"GET"})
     */
    public function show(Attachement $attachement): Response
    {
        return $this->render('attachement/show.html.twig', [
            'attachement' => $attachement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_attachement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Attachement $attachement, AttachementRepository $attachementRepository): Response
    {
        $form = $this->createForm(AttachementType::class, $attachement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attachementRepository->add($attachement);
            return $this->redirectToRoute('app_attachement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('attachement/edit.html.twig', [
            'attachement' => $attachement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_attachement_delete", methods={"POST"})
     */
    public function delete(Request $request, Attachement $attachement, AttachementRepository $attachementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attachement->getId(), $request->request->get('_token'))) {
            $attachementRepository->remove($attachement);
        }

        return $this->redirectToRoute('app_attachement_index', [], Response::HTTP_SEE_OTHER);
    }
}
