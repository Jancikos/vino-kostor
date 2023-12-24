<?php

namespace App\Controller;

use App\Model\Customer;
use App\Model\CustomerQuery;
use App\Utils\JsonResponse\FlashMessageType;
use App\Utils\JsonResponse\JsonDataResponse;
use App\Utils\JsonResponse\JsonValidationResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/customers", name="admin_customers_")
 */
class CustomerController extends AdminController
{
    public function __construct()
    {
        $this->addBreadcrumb('Zákazníci', 'admin_customers_index');
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->renderAdminPage(
            'Zákazníci',
            'customers',
            [
                'customers' => CustomerQuery::create()->find()
            ]
        );
    }

    /**
     * @Route("/form/{pk}", name="form", defaults={"pk": 0})
     */
    public function form($pk = 0): Response
    {
        $customer = CustomerQuery::create()->findOneByPk($pk);
        $editMode = true;
        if ($customer === null) {
            if ($pk !== 0) {
                $this->addFlash(FlashMessageType::DANGER, 'Zákazník nebol nájdený.');
                return $this->redirectToRoute('admin_customers_index');
            }

            $customer = new Customer();
            $editMode = false;
            $this->addBreadcrumb('Nový zákazník', 'admin_customers_form');
        } else {
            $this->addBreadcrumb('Zákazník ' . $customer->getFullName(), 'admin_customers_form');
        }

        return $this->renderAdminPage(
            'Zákazník - formulár',
            'customer_form',
            [
                'customerModel' => $customer,
                'editMode' => $editMode
            ]
        );
    }

    /**
     * @Route("/save", name="save", methods={"POST"})
     */
    public function save(Request $request): Response
    {
        /** @var Customer $product */
        $customer = CustomerQuery::create()->findOneByPk($request->request->get('pk'));
        $isNew = false;
        if ($customer === null) {
            $customer = new Customer();
            $isNew = true;
        }

        $customer->setFirstname($request->request->get('firstname'));
        $customer->setLastname($request->request->get('lastname'));
        $customer->setEmail($request->request->get('email'));
        $customer->setPhone($request->request->get('phone'));
        $customer->setAddress($request->request->get('address'));
        $customer->setCity($request->request->get('city'));
        $customer->setNote($request->request->get('note'));

        $validationResponse = JsonValidationResponse::ValidateModel($customer);

        if ($validationResponse->getSuccess()) {
            $customer->save();
            $this->addFlash(FlashMessageType::SUCCESS, 'Zákazník bol ' . ($isNew ? 'vytvorený' : 'upravený') . '.');
        }
        
        return $validationResponse->toJsonResponse();
    }
    
    /**
     * @Route("/delete", name="delete", methods={"POST"})
     */
    public function delete(Request $request): Response
    {
        /** @var Customer $customer */
        $customer = CustomerQuery::create()->findPk($request->request->get('pk_'));
        
        if ($customer === null) {
            return JsonDataResponse::FailedResponse("Zákazník nebol nájdený.")->toJsonResponse();
        }

        $customer->delete();
        $this->addFlash(FlashMessageType::SUCCESS, 'Zákazník bol vymazaný.');
        
        return JsonDataResponse::SuccessResponse()->toJsonResponse();
    }
}
