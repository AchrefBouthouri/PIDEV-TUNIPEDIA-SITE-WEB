<?php

namespace App\Controller;

use App\Entity\Place;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(): Response
    {

        $p=$this->getDoctrine()->getRepository(Place::class);
        $Place=$p->findAll();

        return $this->render('home/index.html.twig', [
            'places'=>$Place
        ]);
    }
}
