<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PathController extends AbstractController
{
    #[Route('/path', name: 'main_path')]
    public function index(): Response
    {
        return $this->render('path/index.html.twig', [
            'controller_name' => 'PathController',
        ]);
    }

    #[Route('/add_path', name: 'add_path')]
    public function addPath(): Response
    {
        return $this->render('path/add_path.html.twig', []);
    }
}
