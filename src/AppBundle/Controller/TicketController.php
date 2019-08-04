<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Note;
use AppBundle\Entity\Ticket;
use AppBundle\Form\NoteType;
use AppBundle\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/ticket")
 */
class TicketController extends Controller
{
    /**
     * @Route("/", name="ticketpage", options={"expose"=true})
     */
    public function ticketAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT t FROM AppBundle:Ticket t INNER JOIN t.employees e WHERE t.status = 'Open' AND (t.userId = ".$this->getUser()->getId()." OR e.id = ".$this->getUser()->getId().")";
        $query = $em->createQuery($dql);
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $query,
            $request->request->getInt('page',1),
            $request->request->get('limit',10)
        );
        // replace this example code with whatever you need
        return $this->render('@App/Ticket/index.html.twig',[
            "tickets"=>$result
        ]);
    }

    /**
     * @Route("/report", name="reportpage", options={"expose"=true})
     */
    public function reportAction(Request $request)
    {
        $startdate = $request->get('_startdate');
        $enddate = $request->get('_enddate');
        if(!isset($startdate) || $startdate == null){
            $startdate=null;
        }else{
            $startdate = date_format(date_create($startdate),'Y-m-d');
        }
        if(!isset($enddate) || $enddate == null){
            $enddate=null;
        }else{
            $enddate = date_format(date_create($enddate),'Y-m-d');
        }

        $tickets = $this->getDoctrine()->getManager()->getRepository(Ticket::class)->getByDateRange($startdate,$enddate);

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $tickets,
            $request->request->getInt('page',1),
            $request->request->get('limit',10)
        );
        // replace this example code with whatever you need
        return $this->render('@App/Report/ticket.html.twig',[
            "tickets"=>$result,
            "startdate" => ($startdate == null || $startdate == "")?"":$startdate,
            "enddate" => ($enddate == null || $enddate == "")?"":$enddate
        ]);
    }

    /**
     * @Route("/create", name="createticketpage")
     */
    public function createticketAction(Request $request)
    {
        // 1) build the form
        $ticket = new Ticket();
        $ticket->setUserId($this->getUser());
        $form = $this->createForm(TicketType::class, $ticket);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ticket);
            $entityManager->flush();
            return $this->redirectToRoute('ticketpage');
        }
        // replace this example code with whatever you need
        return $this->render('@App/Ticket/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/view", name="viewticketpage")
     */
    public function viewticketAction(Request $request,Ticket $ticket)
    {
        $notes = $ticket->getNotes();
        $employees = $ticket->getEmployees();
        // replace this example code with whatever you need
        return $this->render('@App/Ticket/view.html.twig',[
            "ticket"=>$ticket,
            "notes"=>$notes,
            "employees"=>$employees
        ]);
    }

    /**
     * @Route("/{id}/edit", name="editticketpage")
     */
    public function editticketAction(Request $request,Ticket $ticket)
    {
        if($this->getUser()->getId() != $ticket->getUserId()->getId()){
            $this->addFlash('error','Not Authorized!');
            return $this->redirectToRoute('ticketpage');
        }
        if($ticket->getStatus() == 'Close'){
            $this->addFlash('error','Ticket is close can\'t be edit!');
            return $this->redirectToRoute('ticketpage');
        }
        // 1) build the form
        $form = $this->createForm(TicketType::class, $ticket);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ticket);
            $entityManager->flush();
            return $this->redirectToRoute('ticketpage');
        }
        // replace this example code with whatever you need
        return $this->render('@App/Ticket/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/delete", name="deleteticketpage", methods={"GET"})
     */
    public function delticketAction(Ticket $ticket)
    {
        if($this->getUser()->getId() != $ticket->getUserId()->getId()){
            $this->addFlash('error','Not Authorized!');
            return $this->redirectToRoute('ticketpage');
        }
        try{
            // 1) Delete Ticket
            $em = $this->getDoctrine()->getManager();
            $em->remove($ticket);
            $em->flush();
            // replace this example code with whatever you need
            $this->addFlash('success','Deleted Successfully');
            return $this->redirectToRoute('ticketpage');
        }catch (\Exception $e){
            $this->addFlash('error','Error System '.$e->getMessage());
            return $this->redirectToRoute('ticketpage');
        }
    }

    /**
     * @Route("/{id}/close", name="closeticket", methods={"GET"})
     */
    public function closeticketAction(Ticket $ticket)
    {
        if($this->getUser()->getId() != $ticket->getUserId()->getId()){
            $this->addFlash('error','Not Authorized!');
            return $this->redirectToRoute('ticketpage');
        }
        try{
            // 1) Delete Ticket
            $em = $this->getDoctrine()->getManager();
            $ticket->setStatus('Close');
            $now = new \DateTime();
            $diff = $now->diff($ticket->getCreatedAt());
            $hours = $diff->h;
            $minutes = $diff->i;
            $hours = (double) $hours + (double) ($diff->days * 24) + (double) ($minutes/60);
            $ticket->setEndedAt(new \DateTime());
            $ticket->setTimehours($hours);
            $em->persist($ticket);
            $em->flush();
            // replace this example code with whatever you need
            $this->addFlash('success','Ticket closed successfully!');
            return $this->redirectToRoute('ticketpage');
        }catch (\Exception $e){
            $this->addFlash('error','Error System '.$e->getMessage());
            return $this->redirectToRoute('ticketpage');
        }
    }

    /**
     * @Route("/rest/addnote", name="addnote", methods={"POST"})
     */
    public  function  addNoteAction(Request $request){
        $notes = new Note();
        $notes->setTicketId($this->getDoctrine()->getManager()->getRepository(Ticket::class)->find($request->get("ticketId")));
        $notes->setUserId($this->getUser());
        $notes->setNote($request->get("note"));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($notes);
        $entityManager->flush();
        return $this->redirectToRoute('ticketpage');
    }

    /**
     * @Route("/rest/note/{id}", name="updatenote", methods={"POST"})
     */
    public  function  updateNoteAction(Request $request,Note $notes){
        if($this->getUser()->getId() != $notes->getUserId()->getId()){
            $this->addFlash('error','Not Authorized!');
            return $this->redirectToRoute('viewticketpage',[
                "id"=>$request->get('ticketId')
            ]);
        }
        $notes->setNote($request->get("note"));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($notes);
        $entityManager->flush();
        $this->addFlash('success','Note updated successfully!');
        return $this->redirectToRoute('viewticketpage',[
            "id"=>$request->get('ticketId')
        ]);
    }

    /**
     * @Route("/{ticketid}/note/{noteid}/delete", name="deletenote", methods={"GET"})
     */
    public  function  deleteNoteAction(Request $request,Ticket $ticketid,Note $noteid){
        if(isset($noteid)){
            if($this->getUser()->getId() != $noteid->getUserId()->getId()){
                $this->addFlash('error','Not Authorized!');
                return $this->redirectToRoute('viewticketpage',[
                    "id"=>$ticketid->getId()
                ]);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($noteid);
            $entityManager->flush();
            $this->addFlash('success','Note deleted successfully!');
            return $this->redirectToRoute('viewticketpage',[
                "id"=>$ticketid->getId()
            ]);
        }
        $this->addFlash('error','Note not exists!');
        return $this->redirectToRoute('viewticketpage',[
            "id"=>$ticketid->getId()
        ]);
    }

}
