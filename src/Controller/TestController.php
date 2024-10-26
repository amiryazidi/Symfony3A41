<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/test/{name}', name: 'app_test')]
    public function index($name): Response
    {
       
        return $this->render('test/index.html.twig', [
            'n' => $name,
        ]);
    }

    #[Route('/msg', name: 'msg')]
    public function msg(): Response
    {
      return new Response('Hello 3A41');
    }

    #[Route('/msg1', name: 'msg1')]
    public function msg1(): Response
    {
      return new Response('<h1>Hello 3A41</h1>');
    }
    #[Route('/msg2', name: 'msg2')]
    public function msg2(): Response
    {
      return new JsonResponse('welcome');
    }

    #[Route('/user', name: 'user')]
    public function ListUser(): Response
    {
        $user=array(array('name'=>'amir',"age"=>25,'email'=>'amir@gmail.com'),
                    array('name'=>'ali' , "age"=>30,'email'=>'ali@esprit.tn'),
                    array('name'=>'salah' , "age"=>35,'email'=>'salah@outlook.com')
                );
        return $this->render('test/user.html.twig', [
            'users' => $user,
        ]);
    }
}
