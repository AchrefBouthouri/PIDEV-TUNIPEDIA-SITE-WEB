<?php

namespace App\Controller;

use App\Entity\Place;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/home1", name="app_home1")
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
