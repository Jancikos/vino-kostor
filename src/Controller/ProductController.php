<?php

namespace App\Controller;

use App\Model\Product;
use App\Model\ProductQuery;
use Propel\Runtime\Map\TableMap;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
            'products',
            [
                'products' => ProductQuery::create()->find()
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
            'product_form',
            []
        );
    }

    /**
     * @Route("/save", name="save", methods={"POST"})
     */
    public function save(Request $request): Response
    {
        $data = $request->request->all();

        /** @var Product $product */
        $product = ProductQuery::create()->findPk($request->request->get('pk_'));
        if ($product === null) {
            $product = new Product();
        }

        $product->setTitle($request->request->get('title'));
        $product->setPrice($request->request->get('price'));
        $product->setActive($request->request->get('active') == 'on' ? 1 : 0);

        $product->save();

        $this->addFlash('success', 'Produkt bol ' . ($product->isNew() ? 'vytvorený' : 'upravený') . '.');
        
        return new JsonResponse(['success' => true]);
    }
}
