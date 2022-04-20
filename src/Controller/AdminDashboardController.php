<?php

namespace App\Controller;

use App\Repository\PlaceRepository;
use App\Entity\Place;
use App\Form\PlaceType;
use \Datetime;


use App\Form\InscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Person;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\ConnexionType;
use App\Repository\PersonRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;


class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="app_admin_dashboard")
     */
    public function index(): Response
    {
        return $this->render('admin_dashboard/index.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);
    }
     /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, SessionInterface $session, UserPasswordEncoderInterface $encoder): Response
    {
        $userRepository = $this->getDoctrine()->getRepository(Person::class);
        $useronline = new Person();
        $connexion = $this->createForm(ConnexionType::class, $useronline);
        $connexion->handleRequest($request);
        if ($connexion->isSubmitted() && $connexion->isValid()) {
            $verifuser = $userRepository->findOneBy(array('Email' => $useronline->getEmail()));
            if (is_null($verifuser) || password_verify($useronline->getPassword(), $verifuser->getPassword()) == false) {
                $this->addFlash('Warning','Email ou mot de passe incorrect');
                //return $this->render('user/message.html.twig', ['message' => 'Email ou mot de passe incorrect']);
            } else {
                if ($verifuser->getRole() == "client") {
                    $session->set('user', $verifuser);
                    return $this->redirectToRoute('app_home');
                } elseif ($verifuser->getRoles() == "admin") {

                    $session->set('user', $verifuser);
                    return $this->redirectToRoute('allusers');
                }

            }

        }
        return $this->render('login.html.twig', [
            'connexion' => $connexion->createView(),
        ]);
    }

    /**
     * @Route("/signup", name="signup")
     */
    public function signup(Request $request, SessionInterface $session, ManagerRegistry $objectManager, UserPasswordEncoderInterface $encoder, TokenGeneratorInterface $tokenGenerator): Response
    {
        $utilisateur = new Person();
        $form = $this->createForm(InscriptionType::class, $utilisateur); //bech twarik les champ l moujoudin
        $form->handleRequest($request);  //recuperer les valeur

        if ($form->isSubmitted() && $form->isValid()) { //verifier le formulaire
            $utilisateur = $form->getData();
            $passwordCrypte = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($passwordCrypte);
            $utilisateur->setRole('admin');
            $utilisateur->setIsPartner(false);
            $now = new DateTime();
            $now->getTimestamp();
            $utilisateur->setCreatedAt($now);
            //$utilisateur->setStatus(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();
            $session->set('user', $utilisateur);
            return $this->redirectToRoute('app_home');
        }
        return $this->render('signup.html.twig', [
            "utilisateur" => $utilisateur,
            "form" => $form->createView()
        ]);
    }


        /**
     * @Route("/allusers", name="allusers")
     */
    public function AllUsers(SessionInterface $session): Response
    
    {
        $utilisateur = $session->get('user');
        if (is_null($utilisateur)) {
            return $this->redirectToRoute('login');
        }
            elseif ($utilisateur->getRole() == "client") {
                return $this->redirectToRoute('app_home');
            } elseif ($utilisateur->getRole() == "admin") {
                return $this->redirectToRoute('allusers');
        }
    }

        /**
     * @Route("/AddPlace", name="AddPlace")
     */
        public function new(Request $request, PlaceRepository $placeRepository, SessionInterface $session): Response
        {
            $session->clear();
            $place = new Place();
            $place->setStatus(1);
            $form = $this->createForm(PlaceType::class, $place);
            $form->add('Ajouter',SubmitType::class); 
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $placeRepository->add($place);
                $this->addFlash('success','Your request sent successfully!');
                return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
            }
            return $this->renderForm('admin_dashboard/AddPlace.html.twig', [
                'place' => $place,
                'p' => $form,
            ]);
        }
           /**
     * @Route("/DeletePlace/{idclass}", name="deleteclass", methods={"POST"})
     */
    public function Delete($idclass,  PlaceRepository $placeRepository){
        
        $class=$placeRepository->find($idclass);
        $em = $this->getDoctrine()->getManager();
        $em->remove($class);
        $em->flush();
       
        return $this->redirectToRoute('AllUsers');
    }
    
    
}
