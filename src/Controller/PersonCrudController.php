<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use App\Form\EditProfileType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/person/crud")
 */
class PersonCrudController extends AbstractController
{
    /**
     * @Route("/users/pass/modifier", name="users_pass_modifier")
     */
    public function editPass(Request $request, UserPasswordEncoderInterface $passwordEncoder,SessionInterface $session)
    {
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();

            // On vérifie si les 2 mots de passe sont identiques
            if($request->request->get('pass') == $request->request->get('pass2')){
              //  $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('pass')));
                $em->flush();
                $this->addFlash('message', 'Mot de passe mis à jour avec succès');

                return $this->redirectToRoute('users');
            }else{
                $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques');
            }
        }
        $utilisateur = $session->get('user');
        return $this->render('person_crud/editpass.html.twig',[
            'person'=> $utilisateur,
        ]);
    }

    /**
     * @Route("/users", name="users")
     */
    public function user(SessionInterface $session)
    
    {
        $utilisateur = $session->get('user');
        return $this->render('person_crud/profile.html.twig',[
            'person' => $utilisateur,
        ]);
    }


   /**
     * @Route("/users/profil/modifier", name="users_profil_modifier")
     */
    public function editProfile(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('users');
        }

        return $this->render('person_crud/editprofile.html.twig', [
            'form' => $form->createView(),
        ]);
    }


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
