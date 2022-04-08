<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/person/crud")
 */
class PersonCrudController extends AbstractController
{
    /**
     * @Route("/", name="app_person_crud_index", methods={"GET"})
     */
    public function index(PersonRepository $personRepository): Response
    {
        return $this->render('person_crud/index.html.twig', [
            'people' => $personRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_person_crud_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PersonRepository $personRepository): Response
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personRepository->add($person);
            return $this->redirectToRoute('app_person_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('person_crud/new.html.twig', [
            'person' => $person,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_person_crud_show", methods={"GET"})
     */
    public function show(Person $person): Response
    {
        return $this->render('person_crud/show.html.twig', [
            'person' => $person,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_person_crud_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Person $person, PersonRepository $personRepository): Response
    {
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personRepository->add($person);
            return $this->redirectToRoute('app_person_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('person_crud/edit.html.twig', [
            'person' => $person,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_person_crud_delete", methods={"POST"})
     */
    public function delete(Request $request, Person $person, PersonRepository $personRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$person->getId(), $request->request->get('_token'))) {
            $personRepository->remove($person);
        }

        return $this->redirectToRoute('app_person_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
