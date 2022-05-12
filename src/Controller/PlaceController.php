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
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\Json;


class PlaceController extends AbstractController
{
         /**
     * @Route("/ShowBack1", name="plsearch")
     */
    public function searchPlanajax1(Request $request,PaginatorInterface $paginator)
    {
        
        $repository = $this->getDoctrine()->getRepository(Place::class);
        $requestString=$request->get('searchValue');
        $plan = $repository->findPlanBySujet($requestString);
        $place=$paginator->paginate($repository->findPlanBySujet($requestString),$request->query->getInt('page',1),10);
        $places=$paginator->paginate($repository->findAll(),$request->query->getInt('page',1),10);
        if (null != $request->get('searchValue')){
        return $this->render('place/utilajax.html.twig', [
            'places' => $place,
        ]);
    }
         return $this->render('place/utilajax.html.twig', [
           'places' => $places,
    ]);
    }
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
     * @Route("/ShowBack", name="app_place_index", methods={"GET"})
     */
    public function index1(PlaceRepository $placeRepository): Response
    {
        return $this->render('place/index.html.twig', [
            'places' => $placeRepository->findAll(),
        ]);
        
        
    }
    /**
     * @Route("/stt", name="stt", methods={"GET"})
     */
    public function stt(PlaceRepository $placeRepository): Response
    {
        $nbrs[]=Array();

        $e1=$placeRepository->findPlaceByType("Public");
        dump($e1);
        $nbrs[]=$e1[0][1];


        $e2=$placeRepository->findPlaceByType("Private");
        dump($e2);
        $nbrs[]=$e2[0][1];


        dump($nbrs);
        reset($nbrs);
        dump(reset($nbrs));
        $key = key($nbrs);
        dump($key);
        dump($nbrs[$key]);

        unset($nbrs[$key]);

        $nbrss=array_values($nbrs);
        dump(json_encode($nbrss));
        //////////////////////////////////////////////////////////////:
        $nbrsr[]=Array();

        $e11=$placeRepository->findPlaceByStatus(1);
        dump($e1);
        $nbrsr[]=$e11[0][1];


        $e22=$placeRepository->findPlaceByStatus(0);
        dump($e22);
        $nbrsr[]=$e22[0][1];


        dump($nbrsr);
        reset($nbrsr);
        dump(reset($nbrsr));
        $keyy = key($nbrsr);
        dump($keyy);
        dump($nbrsr[$keyy]);

        unset($nbrsr[$keyy]);

        $nbrssr=array_values($nbrsr);
        dump(json_encode($nbrssr));
        return $this->render('place/statp.html.twig', [
            'nbr' => json_encode($nbrss),
            'nbrr' => json_encode($nbrssr),
        ]);
        
        
    }
       /**
      * @Route("/displayPlace", name="display_place")
      */
      public function AllPlaceAct(Request $request)
      {
              $id = $request->get("id");
 
          $place = $this->getDoctrine()->getManager()->getRepository(Place::class)->findAll();
          
          $serializer = new Serializer([new ObjectNormalizer()]);
          $formatted = $serializer->normalize($place);
 
          return new JsonResponse($formatted);
 
      }
      /**
     * @Route("/deleteP/{id}", name="dlplace", methods={"POST"})
     */
    public function deleteP($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $place = $em->getRepository(Place::class)
            ->findOneBy(array('id' => $id));
        $em = $this->getDoctrine()->getManager();
        $this->getDoctrine()->getManager()->remove($place);
        $em->remove($place);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($place);
        return new JsonResponse($formatted);
    }
      /**
      * @Route("/addp", name="addp")
      * @Method("POST")
      */

      public function ajouterPlace(Request $request , AttachementRepository $AttachementRepository)
      {
          $place = new Place();
          $Attachement = new Attachement();
          $Name = $request->query->get("Name");
          $Description = $request->query->get("Description");
          $Adress = $request->query->get("Adress");
          $City = $request->query->get("City");
          $PostalCode = $request->query->get("PostalCode");
          $Latitude = $request->query->get("Latitude");
          $Longitude = $request->query->get("Longitude");
          $Type = $request->query->get("type");
          $ImageName = $request->query->get("path");
          
          $em = $this->getDoctrine()->getManager();
 

          $Attachement->setName($ImageName);

          $place->setName($Name);
          $place->setDescription($Description);
          $place->setAdress($Adress);
          $place->setCity($City);
          $place->setPostalCode($PostalCode);
          $place->setLatitude($Latitude);
          $place->setLongitude($Longitude);
          $place->setType($Type);
          $place->setStatus(1);
          $place->setAttachement($Attachement);


          $em->persist($place);
          $em->flush();
          $serializer = new Serializer([new ObjectNormalizer()]);
          $formatted = $serializer->normalize($place);
          return new JsonResponse($place);
 
      }
        /**
     * @Route("/Browse", name="Browse", methods={"GET"})
     */
    public function Browse(PlaceRepository $placeRepository, SerializerInterface $SerializerInterface): Response
    {
        $Place=$placeRepository->findAll();
        $c=$this->getDoctrine()->getRepository(Category::class);
        $Category=$c->findAll();
        $json = $SerializerInterface -> serialize($Place,'json', ['groups' => 'Places']);
        return $this->render('place/Browse.html.twig', [
            'categories'=>$Category,
            'places' => $json,
        ]);
    }


    /**
     * @Route("/newFront", name="app_place_new", methods={"GET", "POST"})
     */
    public function newFront(Request $request, PlaceRepository $placeRepository , AttachementRepository $AttachementRepository, SerializerInterface $SerializerInterface): Response
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
        $json = $SerializerInterface -> serialize($place,'json', ['groups' => 'Places']);
        return $this->renderForm('place/new.html.twig', [
            'place' => $place,
            'p' => $form,
            'placejson' => $json,
            'categories' => $Category,
        ]);
    }
    /**
     * @Route("/{id}", name="app_place_show", methods={"GET"})
     */
    public function show(Place $place ,SerializerInterface $SerializerInterface): Response
    {        $c=$this->getDoctrine()->getRepository(Category::class);
        $Category=$c->findAll();
        $json = $SerializerInterface -> serialize($place,'json', ['groups' => 'Places']);
        return $this->render('place/show.html.twig', [
            'place' => $place,
            'placejson' => $json,
            'categories' => $Category,
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
     * @Route("/ShowBack/search", name="plsearch1")
     */
    public function searchPlanajax(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Place::class);
        $requestString=$request->get('searchValue');
        $plan = $repository->findPlanBySujet($requestString);
        return $this->render('place/utilajax.html.twig', [
            'places' => $plan,
        ]);

    }
    
        /**
     * @Route("/ShowBack/TrierParNomASC", name="TrierParNomASC", methods={"GET"})
     */
    public function TrierParNomASC(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p FROM App\Entity\Place p ORDER BY p.Name ASC'
        );
        $place = $query->getResult();
        return $this->render('place/index.html.twig',
            array('places'=>$place));
    }
            /**
     * @Route("/ShowBack/TrierParNomDESC", name="TrierParNomDESC", methods={"GET"})
     */
    public function TrierParNomDESC(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p FROM App\Entity\Place p ORDER BY p.Name DESC'
        );
        $place = $query->getResult();
        return $this->render('place/index.html.twig',
            array('places'=>$place));
    }
            /**
     * @Route("/ShowBack/{id}", name="Accept", methods={"POST"})
     */
    public function Accept(Request $request,Place $place, PlaceRepository $placeRepository): Response
    {
        if ($this->isCsrfTokenValid('update'.$place->getId(), $request->request->get('_token'))) {
            $placeRepository->updatePlaceStatus($place->getId());
        }

        return $this->redirectToRoute('app_place_index', [], Response::HTTP_SEE_OTHER);
    }

}
