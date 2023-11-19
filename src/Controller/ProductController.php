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
     * @Route("/form/{pk}", name="form", defaults={"pk": 0})
     */
    public function form($pk = 0): Response
    {
        $product = ProductQuery::create()->findPk($pk);
        $editMode = true;
        if ($product === null) {
            if ($pk !== 0) {
                $this->addFlash(FlashMessageType::DANGER, 'Produkt nebol nájdený.');
                return $this->redirectToRoute('admin_products_index');
            }

            $product = new Product();
            $editMode = false;
        }

        return $this->renderAdminPage(
            'Produkt - formulár',
            'product_form',
            [
                'product' => $product,
                'editMode' => $editMode
            ]
        );
    }

    /**
     * @Route("/save", name="save", methods={"POST"})
     */
    public function save(Request $request): Response
    {
        /** @var Product $product */
        $product = ProductQuery::create()->findPk($request->request->get('pk'));
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
        
        if ($product === null) {
            return JsonDataResponse::FailedResponse("Produkt nebol nájdený.")->toJsonResponse();
        }

        $product->delete();
        $this->addFlash(FlashMessageType::SUCCESS, 'Produkt bol vymazaný.');
        
        return JsonDataResponse::SuccessResponse()->toJsonResponse();
    }
}
