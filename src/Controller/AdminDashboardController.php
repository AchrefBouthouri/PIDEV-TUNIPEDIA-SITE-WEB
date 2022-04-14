<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Person;
use App\Form\ConnexionType;
use App\Repository\PersonRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


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
        $personRepository = $this->getDoctrine()->getRepository(Person::class);
        $useronline = new Person();
        $connexion = $this->createForm(ConnexionType::class, $useronline);
        $connexion->handleRequest($request);
        if ($connexion->isSubmitted() && $connexion->isValid()) {
            $verifuser = $personRepository->findOneBy(array('Email' => $useronline->getEmail()));
            //var_dump($verifuser);
            //$passwordCrypte = $encoder->encodePassword($verifuser, $verifuser->getPassword());
            //var_dump($passwordCrypte);

            if (is_null($verifuser)) {
               return $this->render('message.html.twig', ['message' => 'Email ou mot de passe incorrect']);
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
     * @Route("/allusers", name="allusers")
     */
    public function AllUsers(SessionInterface $session): Response

    {
        $token = $session->get('user');
        if (is_null($token)) {
            return $this->redirectToRoute('login');

        }
        return $this->render('admin_dashboard/AllUsers.html.twig');
    }
}
