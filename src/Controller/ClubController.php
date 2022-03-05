<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClassroomType;
use App\Form\ClubType;
use App\Form\StudentType;
use App\Repository\ClubRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{
    /**
     * @Route("/club", name="club")
     */
    public function index(): Response
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }
    /**
     * @Route("/getname", name="club")
     */
    public function getnameStatic(): Response
    {
        return $this->render('club/index.html.twig', [
            'getname' => 'ahmed',
        ]);
    }
    /**
     * @Route("/club/get/{name}", name="name")
     */
    public function getname($name): Response
    {

        return $this->render('club/detail.html.twig', [
            'nom' => $name,
        ]);
    }
    /**
     * @Route("/club/list", name="listClub")
     */
    public function list(): Response
    {

        $clubs=$this->getDoctrine()->getRepository(Club::class)->findAll();

        return $this->render('club/list.html.twig', [
            'clubs'=>$clubs,
        ]);
    }

    /**
     * @Route("/club/add", name="addclub")
     */
    public function addclub(Request $request): Response
    {
        $c=new Club();
        $form=$this->createForm(ClubType::class,$c);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($c);
            $em->flush();
            return $this->redirectToRoute("listClub");
        }

        return $this->render('club/addClubForm.html.twig', [
            'myform' => $form->createView(),
        ]);
    }
    /**
     * @Route("/club/update/{id}", name="updateClub")
     */
    public function updateClub(Request $request ,$id,ClubRepository $repository): Response
    {
        $c=$repository->find($id);
        $form=$this->createForm(ClubType::class,$c);

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($c);
            $em->flush();
            return $this->redirectToRoute("listClub");
        }
        return $this->render('club/addClubForm.html.twig', [
            'myform' => $form->createView(),
        ]);

    }
    /**
     * @Route("/club/delete/{id}", name="deleteclub")
     */
    public function deleteClub($id,ClubRepository $repository): Response
    {
        $c =$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($c);
        $em->flush();
        return $this->redirectToRoute("listClub");
    }
}
