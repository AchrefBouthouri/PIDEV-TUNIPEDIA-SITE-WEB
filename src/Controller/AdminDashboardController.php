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
use App\Repository\ReservationRepository;
use App\Repository\EvaluationRepository;
use App\Repository\OfferRepository;
use App\Repository\ReclamationRepository;
use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;


class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin_dashboard")
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
                } elseif ($verifuser->getRole() == "admin") {

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
            $utilisateur->setRole('client');
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
     * @Route("/admin/dashboard/users", name="allusers")
     */
    public function AllUsers(SessionInterface $session,PersonRepository  $PersonRepository): Response
    
    {
        $utilisateur = $session->get('user');
        if (is_null($utilisateur)) {
            return $this->redirectToRoute('login');
        }
            elseif ($utilisateur->getRole() == "client") {
                return $this->redirectToRoute('app_home');
            } elseif ($utilisateur->getRole() == "admin") {
                return $this->render('admin_dashboard/AllUsersSearch.html.twig',[
                    'clients' => $PersonRepository->findAll(),
                ]);
        }
    }

            /**
     * @Route("/admin/dashboard/reservations", name="allreservations")
     */
    public function AllReservations(SessionInterface $session,ReservationRepository  $ReservationRepository): Response
    
    {
        $utilisateur = $session->get('user');
        if (is_null($utilisateur)) {
            return $this->redirectToRoute('login');
        }
            elseif ($utilisateur->getRole() == "client") {
                return $this->redirectToRoute('app_home');
            } elseif ($utilisateur->getRole() == "admin") {
                return $this->render('admin_dashboard/AllReservations.html.twig',[
                    'Reservations' => $ReservationRepository->findAll(),
                ]);
        }
    }
    
            /**
     * @Route("/admin/dashboard/reclamations", name="allreclamations")
     */
    public function AllReclamations(SessionInterface $session,ReclamationRepository  $ReclamationRepository): Response
    
    {
        $utilisateur = $session->get('user');
        if (is_null($utilisateur)) {
            return $this->redirectToRoute('login');
        }
            elseif ($utilisateur->getRole() == "client") {
                return $this->redirectToRoute('app_home');
            } elseif ($utilisateur->getRole() == "admin") {
                return $this->render('admin_dashboard/AllReclamations.html.twig',[
                    'Reclamations' => $ReclamationRepository->findAll(),
                ]);
        }
    }
                /**
     * @Route("/admin/dashboard/offers", name="alloffers")
     */
    public function AllOffers(SessionInterface $session,OfferRepository  $OfferRepository): Response
    
    {
        $utilisateur = $session->get('user');
        if (is_null($utilisateur)) {
            return $this->redirectToRoute('login');
        }
            elseif ($utilisateur->getRole() == "client") {
                return $this->redirectToRoute('app_home');
            } elseif ($utilisateur->getRole() == "admin") {
                return $this->render('admin_dashboard/AllOffer.html.twig',[
                    'Offers' => $OfferRepository->findAll(),
                ]);
        }
    }

                    /**
     * @Route("/admin/dashboard/events", name="allevents")
     */
    public function Allevents(SessionInterface $session,EventRepository  $EventRepository): Response
    
    {
        $utilisateur = $session->get('user');
        if (is_null($utilisateur)) {
            return $this->redirectToRoute('login');
        }
            elseif ($utilisateur->getRole() == "client") {
                return $this->redirectToRoute('app_home');
            } elseif ($utilisateur->getRole() == "admin") {
                return $this->render('admin_dashboard/AllEvents.html.twig',[
                    'Events' => $EventRepository->findAll(),
                ]);
        }
    }
                       /**
     * @Route("/admin/dashboard/evaluations", name="allevaluations")
     */
    public function Allevaluations(SessionInterface $session,EvaluationRepository  $EvaluationRepository): Response
    
    {
        $utilisateur = $session->get('user');
        if (is_null($utilisateur)) {
            return $this->redirectToRoute('login');
        }
            elseif ($utilisateur->getRole() == "client") {
                return $this->redirectToRoute('app_home');
            } elseif ($utilisateur->getRole() == "admin") {
                return $this->render('admin_dashboard/AllEvaluations.html.twig',[
                    'Evaluations' => $EvaluationRepository->findAll(),
                ]);
        }
    }

            /**
     * @Route("/logout", name="logout")
     */
    public function logout(SessionInterface $session): Response
    
    {
       $session->clear();

            return $this->redirectToRoute('login');
    }

    /**
     * @Route("/Person/Search", name="Search")
     */
    public function Search(PersonRepository  $PersonRepository,Request $request): Response
    
    {
                $requestString=$request->get('searchValue');
                return $this->render('admin_dashboard/Search.html.twig',[
                    'clients' => $PersonRepository->findUser($requestString),
                ]);
        }
    

    
    
}
