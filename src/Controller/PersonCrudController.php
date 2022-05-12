<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Entity\Attachement;
use App\Form\EditProfileType;

use App\Repository\PersonRepository;
use Cloudinary\Api\Upload\UploadApi;
use App\Repository\AttachementRepository;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



/**
 * @Route("/person/crud")
 */
class PersonCrudController extends AbstractController


{

    
   
    

    /**
     * @Route("/SignUp", name="SignUp")

     */

    public function SignUp(Request $request)
    {
        $person = new Person();
        $em = $this->getDoctrine()->getManager();

        $person->setFullName($request->query->get("fullname"));
        $person->setEmail($request->query->get("email"));
        $person->setPassword($request->query->get("password"));
        $person->setCreatedAt(new \DateTime('now'));
        $person->setRole('client');
        $person->setIsPartner(false);


        $em->persist($person);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($person);
        return new JsonResponse($formatted);
    }
    /**
     * @Route("/SignIn", name="SignIn")
     * @Method("GET")
     */

    public function SignIn(Request $request)
    {
        $userRepository = $this->getDoctrine()->getRepository(Person::class);
        $person = $userRepository->findOneBy(array('Email' => $request->get("email")));
        // if (is_null($person) || password_verify($request->get("password"), $person->getPassword()) == false) {
        //     return new JsonResponse("User invalide.");
        // } else {
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($person);
            var_dump($formatted);
            return new JsonResponse($formatted);
        // }
    }

    /**
     * @Route("/displayPerson", name="display_person")
     */
    public function allPerson()
    {

        $person = $this->getDoctrine()->getManager()->getRepository(Person::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($person);

        return new JsonResponse($formatted);
    }




    /**
     * @Route("/users/pass/modifier", name="users_pass_modifier")
     */
    public function editPass(Request $request, UserPasswordEncoderInterface $encoder, SessionInterface $session)
    {
        $avatar = new Attachement();
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();

            $user = $session->get('user');
            $data = (new UploadApi())->upload('person.webp');
            //var_dump($Attachement);
            $avatar->setName("person.webp");
            $avatar->setPath($data["url"]);
            $user->setAvatar($avatar);

            // On vérifie si les 2 mots de passe sont identiques
            $passwordCrypte = $encoder->encodePassword($user, $request->request->get('pass'));
            if ($request->request->get('pass') == $request->request->get('pass2') && password_verify($user->getPassword(), $passwordCrypte) == false) {

                $user->setPassword($encoder->encodePassword($user, $request->request->get('pass')));

                $em->flush();
                $this->addFlash('message', 'Mot de passe mis à jour avec succès');

                return $this->redirectToRoute('users');
            } else {
                $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques');
            }
        }
        $utilisateur = $session->get('user');
        return $this->render('person_crud/editpass.html.twig', [
            'person' => $utilisateur,
        ]);
    }

    /**
     * @Route("/users", name="users")
     */
    public function user(SessionInterface $session, PersonRepository $PersonRepository)

    {
        $utilisateur = $session->get('user');
        if ($utilisateur->getRole() == "client") {
            return $this->redirectToRoute('app_home');
        } elseif ($utilisateur->getRole() == "admin") {
            return $this->redirectToRoute('allusers');
        } elseif ($utilisateur->getRole() == "owner") {
            return $this->render('person_crud/profile.html.twig', [
                'person' => $utilisateur,
            ]);
        }
    }


    /**
     * @Route("/users/profil/modifier", name="users_profil_modifier")
     */
    public function editProfile(Request $request, SessionInterface $session, AttachementRepository $AttachementRepository)
    {
        $user = $session->get('user');
        $avatar = new Attachement();
        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$image = $form->get('Avatar')->getData();
            //print_r($image);
            //var_dump($avatar->getPath());
            //$file = $avatar->getFile();
            // $Name = md5(uniqid()) . '.' . $file->guessExtension();
            // $file->move('../public/Attachements/',$Name);
            // $Attachement->setName($Name);

            //var_dump($file);
            $data = (new UploadApi())->upload('person.webp');
            //var_dump($Attachement);
            $avatar->setName("person.webp");
            $avatar->setPath($data["url"]);
            $user->setAvatar($avatar);
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
            //$Attachement = $person->getAvatar();
            //$data=(new UploadApi())->upload($Attachement);
            //$Attachement->setPath($data["url"]);
            //$Attachement->setName($data[""]);
            //print_r($data);

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
        if ($this->isCsrfTokenValid('delete' . $person->getId(), $request->request->get('_token'))) {
            $personRepository->remove($person);
        }

        return $this->redirectToRoute('app_person_crud_index', [], Response::HTTP_SEE_OTHER);
    }

     /**
     * @Route("/persona/{id}", name="person")
     */
    public function PersonById($id)
    {

        $person = $this->getDoctrine()->getManager()->getRepository(Person::class)->findOneBy($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($person);

        return new JsonResponse($person->getId());
    }
}
