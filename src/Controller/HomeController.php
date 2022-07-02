<?php

namespace App\Controller;

use App\Form\UsersFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UsersRepository;

class HomeController extends AbstractController
{

    private $entityManager;   

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_home')]
    public function index(Request $request, UsersRepository $userRepository): Response
    {
        $form = $this->createForm(UsersFilterType::class);
        $form->handleRequest($request);

        $criteria = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $criteria = ['name' =>$form->getData()['username']];
        }

        $users = $userRepository->findBy($criteria);
        
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'users' => $users,
            'users_filter' => $form->createView(),
        ]);
    }
}
