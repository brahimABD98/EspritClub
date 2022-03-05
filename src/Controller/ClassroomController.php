<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    /**
     * @Route("/classroom", name="classroom")
     */
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
    /**
     * @Route("/classroom/list", name="getAll")
     */
    public function getall(): Response
    {
    $list=$this->getDoctrine()->getRepository(Classroom::class)->findAll();     //  $list=$this->getDoctrine()->getRepository(ClassroomRepository::class)->findAll();
        return $this->render('classroom/list.html.twig', [
            'list' => $list,
        ]);
    }
    /**
     * @Route("/classroom/list/{id}", name="element")
     */
    public function getclassroombyid($id): Response
    {
        $element=$this->getDoctrine()->getRepository(Classroom::class)->find($id);
            //  $list=$this->getDoctrine()->getRepository(ClassroomRepository::class)->findAll();
        return $this->render('classroom/listbyid.html.twig', [
            'element' => $element,
        ]);
    }
    /**
     * @Route("/classroom/add", name="add")
     */
    public function add_classroom(ClassroomRepository $repository): Response
    {
        $c=new Classroom();
        $c->setNom("3A12");
        $em=$this->getDoctrine()->getManager();
        $em->persist($c);
        $em->flush();
        return  $this->redirectToRoute("getAll");

    }
    /**
     * @Route("/classroom/delete/{id}", name="delete")
     */
    public function remove_classroom(ClassroomRepository $repository,$id): Response
    {
        $c=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($c);
        $em->flush();
        return  $this->redirectToRoute("getAll");
    }
    /**
     * @Route("/addClassroom", name="formAddClassroom")
     */
    public function add_classroom_form(Request $request): Response
    {
        $c=new Classroom();
        $form=$this->createForm(ClassroomType::class,$c);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($c);
            $em->flush();
            return $this->redirectToRoute("getAll");
        }

       return $this->render('Classroom/addForm.html.twig',[
           'myform'=>$form->createView(),
    ]);

    }
    /**
     * @Route("/classroom/update/{id}", name="updateform")
     */
    public function update_classroom_form($id,Request $request,ClassroomRepository $repository): Response
    {
        $c=$repository->find($id);
        $form=$this->createForm(ClassroomType::class,$c);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($c);
            $em->flush();
            return $this->redirectToRoute("getAll");
        }

        return $this->render('Classroom/addForm.html.twig',[
            'myform'=>$form->createView(),
        ]);

    }

}
