<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/products", name="admin_products_")
 */
class ProductController extends AdminController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {

        return $this->renderAdminPage(
            'Produkty',
            'products', [

            ]
        );
    }

    /**
     * @Route("/form", name="form")
     */
    public function form(): Response
    {

        return $this->renderAdminPage(
            'Produkt - formulár',
            'product_form', [

            ]
        );
    }

}
