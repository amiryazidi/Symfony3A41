<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\ClassroomRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
    
    #[Route('/lists', name: 'lists')]
    public function list(StudentRepository $r){

    $result = $r->findAll();
    return $this->render('student/list.html.twig',
    ['students'=>$result]);
    }

    #[Route('/add', name: 'add')]
    public function add(ManagerRegistry $mr,  Request $req )
    {

    $s = new Student();
    $form= $this->createForm(StudentType::class, $s); // creaton de la formulaire
    $form->handleRequest($req);  // nous permet d'analyser la requete et recuperer les donnees du formulaire
   
    if ($form->isSubmitted()) 
    {
        $em= $mr->getManager();
        $em->persist($s);
        $em->flush();
    }

    return $this->render('student/add.html.twig', [
        'f'=>$form]);    // envoyer le formulaire a la vue
    }
  
    #[Route('/update/{id}', name: 'update')]
    public function update(StudentRepository $studentRepository, $id, ManagerRegistry $mr)
    {
        $student = $studentRepository->find($id);
        if(!$student)
        {
            throw $this->createNotFoundException(
                "Student not found for id .$id"
            );
        }
        $student->setNom("Fawzi");
        $student->setAge(15);
        $em =$mr->getManager();
        $em->persist($student);
        $em->flush();
        return $this->redirectToRoute('lists');
    }

    #[Route('/dql', name: 'dql')]
    public function listDql(EntityManagerInterface $mr,
    Request $request,StudentRepository $repo): Response
    {
            $result= $repo->findAll();
          

     if ($request->isMethod('post')){
  
      $value=$request->get('nom');
        $result= $repo->fetchStudentsByName($value);
 
    }
       
        return $this->render('student/dql.html.twig', [
            'students' => $result,
        ]);
    }

    #[Route('/dql2', name: 'dql2')]
    public function dql2(EntityManagerInterface $mr,StudentRepository $repo): Response
    {
        $result=$repo->fetchStudentByAge();
       dd($result);
    }

    #[Route('/dql3', name: 'dql3')]
    public function dql3(EntityManagerInterface $mr): Response
    {
        $req=$mr->createQuery("select s.nom from App\Entity\Student s 
        where s.nom='fawzi'");
        $result=  $req->getResult();
       dd($result);
    }

    #[Route('/join', name: 'join')]
    public function join(StudentRepository $repo): Response
    {
        $result=$repo->join();
       dd($result);
    }

    #[Route('/qb', name: 'qb')]
    public function qb(StudentRepository $repo): Response
    {
        $result=$repo->QB();
       dd($result);
    }
}
