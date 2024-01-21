<?php

namespace App\Controller;

use App\Utils\Datafeed\ProductsListPublic;
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
        $productsDatafeed = new ProductsListPublic();
        return $this->render('public/index.html.twig', [
            'products' => $productsDatafeed->getData(),
        ]);
    }
}
