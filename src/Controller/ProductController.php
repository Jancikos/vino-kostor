<?php

namespace App\Controller;

use App\Model\Product;
use App\Model\ProductQuery;
use App\Utils\JsonResponse\FlashMessageType;
use App\Utils\JsonResponse\JsonDataResponse;
use App\Utils\JsonResponse\JsonValidationResponse;
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
        /** @var Product $product */
        $product = ProductQuery::create()->findPk($request->request->get('pk_'));
        $isNew = false;
        if ($product === null) {
            $product = new Product();
            $isNew = true;
        }

        $product->setTitle($request->request->get('title'));
        $product->setPrice($request->request->get('price'));
        $product->setActive($request->request->get('active') == 'on' ? 1 : 0);

        $validationResponse = JsonValidationResponse::ValidateModel($product);

        if ($validationResponse->getSuccess()) {
            $product->save();
            $this->addFlash(FlashMessageType::SUCCESS, 'Produkt bol ' . ($isNew ? 'vytvorený' : 'upravený') . '.');
        }
        
        return $validationResponse->toJsonResponse();
    }
    
    /**
     * @Route("/delete", name="delete", methods={"POST"})
     */
    public function delete(Request $request): Response
    {
        /** @var Product $product */
        $product = ProductQuery::create()->findPk($request->request->get('pk_'));
        
        if ($product !== null) {
            return JsonDataResponse::FailedResponse("Produkt nebol nájdený.")->toJsonResponse();
        }

        $product->delete();
        $this->addFlash(FlashMessageType::SUCCESS, 'Produkt bol vymazaný.');
        
        return JsonDataResponse::SuccessResponse()->toJsonResponse();
    }
}
