<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/home.html.twig', [
            'controller_name' => 'AdminController',
            'pageName' => 'Home'
        ]);
    }

    #[Route('admin/home', name: 'app_admin_home')]
    public function home(): Response
    {
        return $this->render('admin/home/home.html.twig', [
            'controller_name' => 'AdminController',
            'pageName' => 'Home'
        ]);
    }
}
