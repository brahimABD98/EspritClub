<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\ClassroomRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="student")
     */
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
    /**
     * @Route("/student/add", name="AddStudent")
     */
    public function AddStudent(Request $request): Response
    {
            $s=new Student();
            $form=$this->createForm(StudentType::class,$s);
            $form->handleRequest($request);
            if($form->isSubmitted())
            {
                $em=$this->getDoctrine()->getManager();
                $em->persist($s);
                $em->flush();
                return $this->redirectToRoute("student");
            }

        return $this->render('student/AddStudentForm.html.twig', [
            'myform' => $form->createView(),
        ]);
    }
    /**
     * @Route("/student/list", name="studentList")
     */
    public function StudentList(): Response
    {
        $students=$this->getDoctrine()->getRepository(Student::class)->findAll();
        return $this->render('student/List.html.twig', [
            'students' => $students,
        ]);
    }

    /**
     * @Route("/student/update/{id}", name="Studentupdate")
     */
    public function StudentUpdate($id,Request $request,StudentRepository $repository): Response
    {
        $s=$repository->find($id);
        $form=$this->createForm(StudentType::class,$s);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($s);
            $em->flush();
            return $this->redirectToRoute("studentList");
        }

        return $this->render('student/AddStudentForm.html.twig', [
            'myform' => $form->createView(),
        ]);
    }

    /**
     * @Route("/student/delete/{id}", name="deletestudent")
     */
    public function deleteStudent($id,ClassroomRepository $repository): Response
    {
        $s=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($s);
        $em->flush();
        return $this->redirectToRoute("studentList");
    }


}
