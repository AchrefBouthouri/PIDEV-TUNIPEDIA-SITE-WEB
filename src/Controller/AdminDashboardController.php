<?php

namespace App\Controller;

use App\Repository\PlaceRepository;
use App\Entity\Place;
use App\Form\PlaceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Person;
use App\Form\ConnexionType;
use App\Repository\PersonRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


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
   
        return $this->render('admin_dashboard/AllUsers.html.twig');
    }
           /**
     * @Route("/AddPlace", name="AddPlace")
     */

        /**
     * @Route("/AddPlace", name="AddPlace")
     */
        public function new(Request $request, PlaceRepository $placeRepository): Response
        {
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
