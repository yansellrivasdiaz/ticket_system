<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/employee")
 */
class EmployeeController extends Controller
{
    /**
     * @Route("/", name="employeepage", methods={"GET"})
     */
    public function EmployeeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT e FROM AppBundle:User e";
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
        return $this->render('@App/Employee/index.html.twig',[
            "employees"=>$result
        ]);
    }

    /**
     * @Route("/create", name="createemployeepage")
     */
    public function createemployeeAction(Request $request,UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $employee = new User();
        $form = $this->createForm(UserType::class, $employee);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        $result = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(["username"=>$form->getData()->getUserName()]);
        if(isset($result) && count($result)>0){
            // replace this example code with whatever you need
            return $this->render('@App/Employee/create.html.twig',[
                'error_message' => "Username already taken by other user!!",
                "form"=>$form->createView()
            ]);
        }
        if ($form->isSubmitted() && $form->isValid()) {
            // 4) save the User!
            try{
                $employee->setPassword($passwordEncoder->encodePassword($employee,$employee->getPlainPassword()));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($employee);
                $entityManager->flush();
                $this->addFlash('success','Employee created successfully');
            }catch (\Exception $e){
                $this->addFlash('error','Error system '.$e->getMessage());
            }
            return $this->redirectToRoute('employeepage');
        }
        // replace this example code with whatever you need
        return $this->render('@App/Employee/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/view", name="viewemployeepage",methods={"GET"})
     */
    public function viewemployeeAction(Request $request,User $employee)
    {
        if(!isset($employee)){
            $this->addFlash('error','Not found!');
            return $this->redirectToRoute('employeepage');
        }
        $tickets = $employee->getTickets();
        // replace this example code with whatever you need
        return $this->render('@App/Employee/view.html.twig',[
            "employee" => $employee,
            "tickets" => $tickets
        ]);
    }

    /**
     * @Route("/{id}/edit", name="editemployeepage")
     */
    public function editemployeeAction(Request $request,User $employee,UserPasswordEncoderInterface $passwordEncoder)
    {
        if($this->getUser()->getId() == $employee->getId()){
            if($request->get('status') != $employee->getStatus()){
                $request->request->set('status',$employee->getStatus());
            }
        }
        // 1) build the form
        $form = $this->createForm(UserType::class, $employee);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // 4) save the User!
            $employee->setPassword($passwordEncoder->encodePassword($employee,$employee->getPlainPassword()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('employeepage');
        }
        // replace this example code with whatever you need
        return $this->render('@App/Employee/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/delete", name="deleteemployeepage")
     */
    public function deleteemployeeAction(Request $request,User $employee)
    {
        if($this->getUser()->getId() == $employee->getId()){
            $this->addFlash('error','Unauthorized');
            return $this->redirectToRoute('employeepage');
        }
        try{
            $entityManager = $this->getDoctrine()->getManager();
            $employee->setStatus('Inactive');
            $entityManager->flush();
            $this->addFlash('success','Desactivared Successfully');
        }catch (\Exception $e){
            $this->addFlash('error','Error System '.$e->getMessage());
        }
        return $this->redirectToRoute('employeepage');
    }

    /**
     * @Route("/{id}/active", name="activeemployeepage")
     */
    public function activeemployeeAction(Request $request,User $employee)
    {
        try{
            $entityManager = $this->getDoctrine()->getManager();
            $employee->setStatus('Active');
            $entityManager->flush();
            $this->addFlash('success','Activated Successfully');
        }catch (\Exception $e){
            $this->addFlash('error','Error System '.$e->getMessage());
        }
        return $this->redirectToRoute('employeepage');
    }

}
