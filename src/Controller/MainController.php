<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(): Response
    {
        return $this->render('public/index.html.twig', [
            
        ]);
    }

    /**
     * @Route("/other", name="app_other")
     */
    public function other(): Response
    {
        return new Response('Other page');
    }
}
