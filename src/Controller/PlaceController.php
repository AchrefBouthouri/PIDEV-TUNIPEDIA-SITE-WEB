<?php

namespace App\Controller;

use App\Entity\Place;
use App\Entity\Attachement;
use App\Entity\Category;
use App\Form\PlaceType;
use App\Repository\PlaceRepository;
use App\Repository\CategoryRepository;
use App\Repository\AttachementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class PlaceController extends AbstractController
{
        /**
     * @Route("/home", name="app_home")
     */
    public function index(): Response
    {

        $p=$this->getDoctrine()->getRepository(Place::class);
        $Place=$p->findAll();
        $c=$this->getDoctrine()->getRepository(Category::class);
        $Category=$c->findAll();

        return $this->render('home/index.html.twig', [
            'places'=>$Place,
            'categories'=>$Category,
        ]);
    }
           /**
     * @Route("/newBack", name="AddPlace", methods={"GET", "POST"})
     */
    public function newBack(Request $request, PlaceRepository $placeRepository , AttachementRepository $AttachementRepository): Response
    {
        $place = new Place();
        $place->setStatus(1);
        $form = $this->createForm(PlaceType::class, $place);
        $form->add('Ajouter',SubmitType::class); 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Attachement = $place->getAttachement();
            $file = $Attachement->getFile();
            $Name = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move('../public/Attachements/',$Name);
            $Attachement->setName($Name);
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
     * @Route("/ShowBack", name="showPlaces", methods={"GET"})
     */
    public function index1(PlaceRepository $placeRepository): Response
    {
        return $this->render('place/index.html.twig', [
            'places' => $placeRepository->findAll(),
        ]);
    }
        /**
     * @Route("/Browse", name="Browse", methods={"GET"})
     */
    public function Browse(PlaceRepository $placeRepository): Response
    {
        
        $c=$this->getDoctrine()->getRepository(Category::class);
        $Category=$c->findAll();
        return $this->render('place/Browse.html.twig', [
            'categories'=>$Category,
            'places' => $placeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ShowBack2", name="app_place_index2")
     */
    public function indexxx(PlaceRepository $placeRepository): Response
    {
        return $this->render('place/index2.html.twig', [
            'places' => $placeRepository->findAll(),
        ]);
       
    }
    /**
     * @Route("/newFront", name="app_place_new", methods={"GET", "POST"})
     */
    public function newFront(Request $request, PlaceRepository $placeRepository , AttachementRepository $AttachementRepository): Response
    {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);
        $form->add('Ajouter',SubmitType::class); 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Attachement = $place->getAttachement();
            $file = $Attachement->getFile();
            $Name = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move('../public/Attachements/',$Name);
            var_dump($Name);
            $Attachement->setName($Name);
            $placeRepository->add($place);
            $this->addFlash('success','Your request sent successfully!');
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
        $c=$this->getDoctrine()->getRepository(Category::class);
        $Category=$c->findAll();
        return $this->renderForm('place/new.html.twig', [
            'place' => $place,
            'p' => $form,
            'categories' => $Category,
        ]);
    }
    /**
     * @Route("/{id}", name="app_place_show", methods={"GET"})
     */
    public function show(Place $place): Response
    {
        return $this->render('place/show.html.twig', [
            'place' => $place,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_place_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Place $place, PlaceRepository $placeRepository): Response
    {
        $form = $this->createForm(PlaceType::class, $place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $placeRepository->add($place);
            return $this->redirectToRoute('app_place_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('place/edit.html.twig', [
            'place' => $place,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_place_delete", methods={"POST"})
     */
    public function delete(Request $request, Place $place, PlaceRepository $placeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$place->getId(), $request->request->get('_token'))) {
            $placeRepository->remove($place);
        }

        return $this->redirectToRoute('app_place_index', [], Response::HTTP_SEE_OTHER);
    }
    

    
    /**
     * @Route("/ShowBack/pdfff", name="PDFWacim" , methods={"GET"})
     */
    function PlacePdf(PlaceRepository $repository)
{
    // Configure Dompdf according to your needs
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');

    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($pdfOptions);
    //l'image est située au niveau du dossier public
    $png = file_get_contents("logo.png");
    $pngbase64 = base64_encode($png);

    // Retrieve the HTML generated in our twig file

    $place = $repository->findAll();
    // Load HTML to Dompdf
    $html = $this->renderView('place/PdfWacim.html.twig',
        [   'places'=> $place,
        "img64"=>$pngbase64
        ]);

    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser (force download)
    $dompdf->stream("pdf.pdf", [
        "Attachment" => false
    ]);

}
    /**
     * @Route("/ShowBack/search", name="plsearch")
     */
    public function searchPlanajax(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Place::class);
        $requestString=$request->get('searchValue');
        $plan = $repository->findPlanBySujet($requestString);
        return $this->render('place/utilajax.html.twig', [
            'util' => $plan,
        ]);

    }
}
