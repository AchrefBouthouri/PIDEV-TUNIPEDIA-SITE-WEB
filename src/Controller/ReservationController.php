<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Dompdf\Dompdf;
use Dompdf\Options;
use Doctrine\ORM\EntityManagerInterface;


class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="app_reservation_index", methods={"GET"})
     */
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }



    /**
     * @Route("/Reservation/new", name="app_reservation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ReservationRepository $reservationRepository, \Swift_Mailer $mailer): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->add('Ajouter',SubmitType::class); 
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

           

        
            $reservationRepository->add($reservation);
            $message = (new \Swift_Message('Reservation'))
            ->setSubject('Reservation')
            ->setFrom('mohamedamine.chouchene@esprit.tn')
            ->setTo('steamaminech@gmail.com')
            ->setBody(
                'Reservation établie'
            )
        ;
        $mailer->send($message);
            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        
       
        }
        return $this->renderForm('reservation/new.html.twig', [
            'reservation' => $reservation,
            'p' => $form,
        ]);
    }

    /**
     * @Route("/Reservation/{id}", name="app_reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/Reservation/{id}/edit", name="app_reservation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationRepository->add($reservation);
            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/Reservation/{id}", name="app_reservation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $reservationRepository->remove($reservation);
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/reservation/trier", name="trier", methods={"GET"})
     */
    public function TrierParDate(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p FROM App\Entity\Reservation p ORDER BY p.Date DESC'
        );
        $Reservation= $query->getResult();
        return $this->render('reservation/index.html.twig',
            array('reservations'=>$Reservation));
    }

    /**
     * @Route("/ShowBack/pdfff", name="PDFWacim" , methods={"GET"})
     */
    function ReservationPdf(ReservationRepository $repository)
{
    // Configure Dompdf according to your needs
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');

    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($pdfOptions);
    //l'image est située au niveau du dossier public
   // $png = file_get_contents("logo.png");
   // $pngbase64 = base64_encode($png);

    // Retrieve the HTML generated in our twig file

    $Reservation = $repository->findAll();
    // Load HTML to Dompdf
    $html = $this->renderView('Reservation/Pdfreservation.html.twig',
        [   'reservations'=> $Reservation,
       // "img64"=>$pngbase64
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
     * @Route("reservation/ShowBack/search", name="plsearch")
     */
    public function searchPlanajax(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Reservation::class);
        $requestString=$request->get('searchValue');
        $plan = $repository->findPlanBySujet($requestString);
        return $this->render('Reservation/searchajax.html.twig', [
            'reservations' => $plan,
        ]);

    }
    /**
     * @Route("/reservation1", name="app_reservation_index1", methods={"GET"})
     */
    public function index1(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index2.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }
    

    /**
     * @Route("/reservation/calendar", name="calendar", methods={"GET"})
     */
    public function calendar(EntityManagerInterface $entityManager): Response
    {
        $reservationEvenet = $entityManager
            ->getRepository(Reservation::class)
            ->findAll();
            
            $reservations = [];

        foreach($reservationEvenet as $reservationEvenet){
            $reservations[] = [
                'id' => $reservationEvenet->getId(),
                'start' => $reservationEvenet-> getDate()->format('Y-m-d'),
                
            ];
        }
        $data = json_encode($reservations);

        return $this->render('reservation/calendar.html.twig', compact('data'));
    }

}