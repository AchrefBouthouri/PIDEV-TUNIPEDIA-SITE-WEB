<?php

namespace App\Controller;

use App\Entity\Programme;
use App\Form\ProgrammeType;
use App\Entity\Category;

use App\Repository\ProgrammeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
 use Symfony\Component\Serializer\Serializer;

use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Serializer\Normalizer;  

/**
 * @Route("/programme")
 */
class ProgrammeController extends AbstractController
{

        /**
     * @Route("/trier", name="trier", methods={"GET"})
     */
    public function TrierParNomASC(Request $request): Response
    {
        $c=$this->getDoctrine()->getRepository(Category::class);
        $Category=$c->findAll();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p FROM App\Entity\Programme p ORDER BY p.name ASC'
        );
        $programme = $query->getResult();
        return $this->render('programme/index.html.twig', [
            'programmes' => $programme,
            'categories'=>$Category,

        ]);
    }
      /******************Supprimer programme*****************************************/

     /**
      * @Route("/deleteprog", name="delete_prog")
      * @Method("DELETE")
      */

      public function deleteReclamationAction(Request $request) {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $Programme = $em->getRepository(Programme::class)->find($id);
        if($Programme!=null ) {
            $em->remove($Programme);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("programme a ete supprimee avec success.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id reclamation invalide.");


    }


       /**
     * @Route("/show", name="app_programme_index", methods={"GET"})
     */
    public function index(ProgrammeRepository $programmeRepository): Response
    {
        $c=$this->getDoctrine()->getRepository(Category::class);
        $Category=$c->findAll();
        //print_r($Category);
        //var($programmeRepository->findAll());

        return $this->render('programme/index.html.twig', [
            'programmes' => $programmeRepository->findAll(),
            'categories'=>$Category,

        ]);

        
       
    }
  

    //Exporter pdf (composer require dompdf/dompdf)
    /**
     * @Route("/pdf", name="PDF_programme", methods={"GET"})
     */
    public function pdf(programmeRepository $programmeRepository)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('programme/pdf.html.twig', [
            'programmes' => $programmeRepository->findAll(),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("ListeDesVoyages.pdf", [
            "programmes" => true
        ]);
    }





    /**
     * @Route("/new", name="app_programme_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProgrammeRepository $programmeRepository): Response
    {
        $programme = new Programme();
        $form = $this->createForm(ProgrammeType::class, $programme);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $programmeRepository->add($programme);
            return $this->redirectToRoute('app_programme_index', [], Response::HTTP_SEE_OTHER);
        }
        $c=$this->getDoctrine()->getRepository(Category::class);
        $Category=$c->findAll();

        return $this->renderForm('programme/new.html.twig', [
            'programme' => $programme,
            'p' => $form,
            'categories'=>$Category,

        ]);
    }

 /******************Ajouter programme*****************************************/
     /**
      * @Route("/addprogramme", name="add_programme")
      * @Method("POST")
      */

      public function ajouterprogramme(Request $request)
      {
          $Programme = new Programme();
          $name = $request->query->get("name");
          $description = $request->query->get("description");
          $date = new \DateTime('now');
          $prix = $request->query->get("prix");

 
          $Programme->setName($name);
          $Programme->setDescription($description);
          $Programme->setDate($date);
          $Programme->setPrix($prix);
          $em = $this->getDoctrine()->getManager();
 
          $em->persist($Programme);
          $em->flush();
          $serializer = new Serializer([new ObjectNormalizer()]);
          $formatted = $serializer->normalize($Programme);
          return new JsonResponse($formatted);
 
      }


   
    /**
     * @Route("/show1", name="Searchy")
     */
    public function searchPlanajax12(Request $request)
    {
        
        $repository = $this->getDoctrine()->getRepository(Programme::class);
        $requestString=$request->get('searchValue');
        $prg = $repository->findAll();
        $prog = $repository->findprg($requestString);
        if (null != $request->get('searchValue')){
        return $this->render('programme/utilajax.html.twig', [
            'programmes' => $prog,
        ]);
    }
         return $this->render('programme/utilajax.html.twig', [
            'programmes' => $prg,
    ]);
    }

   

    /**
     * @Route("/{id}", name="app_programme_show", methods={"GET"})
     */
    public function show(Programme $programme): Response
    {
        $c=$this->getDoctrine()->getRepository(Category::class);
        $Category=$c->findAll();
        return $this->render('programme/show.html.twig', [
            'programme' => $programme,
            'categories'=>$Category,
            
        ]);
        }

    /**
     * @Route("/{id}/edit", name="app_programme_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Programme $programme, ProgrammeRepository $programmeRepository): Response
    {
        $form = $this->createForm(ProgrammeType::class, $programme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $programmeRepository->add($programme);
            return $this->redirectToRoute('app_programme_index', [], Response::HTTP_SEE_OTHER);
        }
        $c=$this->getDoctrine()->getRepository(Category::class);
        $Category=$c->findAll();
        return $this->renderForm('programme/edit.html.twig', [
            'programme' => $programme,
            'form' => $form,
            'categories'=>$Category,

        ]);
    }

    /**
     * @Route("/{id}", name="app_programme_delete", methods={"POST"})
     */
    public function delete(Request $request, Programme $programme, ProgrammeRepository $programmeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$programme->getId(), $request->request->get('_token'))) {
            $programmeRepository->remove($programme);
        }

        return $this->redirectToRoute('app_programme_index', [], Response::HTTP_SEE_OTHER);
    }
  



}
