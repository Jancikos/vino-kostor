<?php

namespace App\Controller;

use App\Model\CustomerQuery;
use App\Model\Order;
use App\Model\OrderItem;
use App\Model\OrderItemQuery;
use App\Model\OrderQuery;
use App\Model\ProductQuery;
use App\Model\UserQuery;
use App\Utils\JsonResponse\FlashMessageType;
use App\Utils\JsonResponse\JsonDataResponse;
use App\Utils\JsonResponse\JsonValidationResponse;
use App\Utils\Orders\OrderStatusCase;
use App\Utils\Orders\OrderStatusManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/orders", name="admin_orders_")
 */
class OrderController extends AdminController
{
    public function __construct()
    {
        $this->addBreadcrumb('Objednávky', 'admin_orders_index');
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->renderAdminPage(
            'Objednávky',
            'orders',
            [
                'orders' => OrderQuery::create()->find()
            ]
        );
    }

    /**
     * @Route("/form/{pk}", name="form", defaults={"pk": 0})
     */
    public function form($pk = 0): Response
    {
        $order = OrderQuery::create()->findOneByPk($pk);
        $editMode = true;
        if ($order === null) {
            if ($pk !== 0) {
                $this->addFlash(FlashMessageType::DANGER, 'Objednávka nebol nájdený.');
                return $this->redirectToRoute('admin_orders_index');
            }

            $order = new Order();
            $editMode = false;
            $this->addBreadcrumb('Nová objednávka', 'admin_orders_form');
        } else {
            $this->addBreadcrumb('Objednávka #' . $order->getPk(), 'admin_orders_form', ['pk' => $order->getPk()]);
        }


        return $this->renderAdminPage(
            'Objednávka - formulár',
            'order_form',
            [
                'order' => $order,
                'editMode' => $editMode,
                'customers' => CustomerQuery::create()->find(),
                'users' => UserQuery::create()->find()
            ]
        );
    }

    /**
     * @Route("/save", name="save", methods={"POST"})
     */
    public function save(Request $request): Response
    {
        /** @var Order $product */
        $order = OrderQuery::create()->findOneByPk($request->request->get('pk'));
        $isNew = false;
        if ($order === null) {
            $order = new Order();
            // set status created @todo

            $isNew = true;
            OrderStatusManager::setOrderStatus($order, OrderStatusCase::CREATED);
        }

        $order->setCustomerPk($request->request->get('customerPk'));
        $order->setUserPk($request->request->get('userPk'));
        $order->setNote($request->request->get('note'));

        $realPrice = $request->request->get('realPrice', "");
        if (!empty($realPrice)) {
            if ($realPrice != $order->getRealPrice()) {
                $order->setRealPrice($realPrice);
                OrderStatusManager::setOrderStatus($order, OrderStatusCase::PAIED);
            }
        }

        $validationResponse = JsonValidationResponse::ValidateModel($order);

        if ($validationResponse->getSuccess()) {
            $order->save();
            if (!$isNew) {
                $this->addFlash(FlashMessageType::SUCCESS, 'Objednávka bola upravená.');
            }

            $validationResponse->addData('orderPk', $order->getPk());
        }

        return $validationResponse->toJsonResponse();
    }
    

    /**
     * @Route("/setStatus", name="set_status", methods={"POST"})
     */
    public function setStatus(Request $request): Response
    {
        /** @var Order $product */
        $order = OrderQuery::create()->findOneByPk($request->request->get('orderPk'));
     
        if ($order === null) {
            return JsonDataResponse::FailedResponse("Objednávka nebola nájdená.")->toJsonResponse();
        }

        $status = OrderStatusCase::tryFrom($request->request->get('nextStatusPk'));
        if ($status === null) {
            return JsonDataResponse::FailedResponse("Neplatný status objednávky.")->toJsonResponse();
        }

        OrderStatusManager::setOrderStatus($order, $status);
        $order->save();

        $this->addFlash(FlashMessageType::SUCCESS, 'Status objednávky bol zmenený.');
        return JsonDataResponse::SuccessResponse()->toJsonResponse();
    }
    /**
     * @Route("/delete", name="delete", methods={"POST"})
     */
    public function delete(Request $request): Response
    {
        /** @var Order $order */
        $order = OrderQuery::create()->findPk($request->request->get('pk_'));

        if ($order === null) {
            return JsonDataResponse::FailedResponse("Objednávka nebola nájdená.")->toJsonResponse();
        }

        $order->delete();
        $this->addFlash(FlashMessageType::SUCCESS, 'Objednávka bola vymazaná.');

        return JsonDataResponse::SuccessResponse()->toJsonResponse();
    }

    ////////////////
    // order item //
    ////////////////

    /**
     * @Route("/{orderPk}/item/{pk}", name="item_form", defaults={"orderPk": 0, "pk": 0})
     */
    public function itemForm($orderPk = 0, $pk = 0): Response
    {
        $order = OrderQuery::create()->findOneByPk($orderPk);
        if ($order === null) {
            $this->addFlash(FlashMessageType::DANGER, 'Objednávka nebola nájdená.');
            return $this->redirectToRoute('admin_orders_index');
        }
        $this->addBreadcrumb('Objednávka #' . $order->getPk(), 'admin_orders_form', ['pk' => $order->getPk()]);

        $orderItem = OrderItemQuery::create()->findOneByPk($pk);
        $editMode = true;
        if ($orderItem == null) {
            if ($pk !== 0) {
                $this->addFlash(FlashMessageType::DANGER, "Položka objednávky #" . $order->getPk() . " nebola nájdená.");
                return $this->redirectToRoute('admin_orders_form', ['pk' => $order->getPk()]);
            }

            $editMode = false;
            $this->addBreadcrumb('Nová položka objednávky', 'admin_orders_item_form', ['orderPk' => $order->getPk()]);
            $orderItem = new OrderItem();
            $orderItem->setOrderPk($orderPk);
        } else {
            $this->addBreadcrumb('Položka objednávky ' . $orderItem->getFullName(), 'admin_orders_item_form');
        }
        
        if ($orderItem->getOrderPk() != $orderPk) {
            $this->addFlash(FlashMessageType::DANGER, "Položka nepatrí k objednávke #" . $order->getPk() . ".");
            return $this->redirectToRoute('admin_orders_form', ['pk' => $order->getPk()]);
        }

        return $this->renderAdminPage(
            'Položka objednávky - formulár',
            'order_item_form',
            [
                'item' => $orderItem,
                'editMode' => $editMode,
                'order' => $order,
                'products' => ProductQuery::create()->find()
            ]
        );
    }
    
    /**
     * @Route("/item/save", name="item_save", methods={"POST"})
     */
    public function itemSave(Request $request): Response
    {
        /** @var OrderItem $product */
        $orderItem = OrderItemQuery::create()->findOneByPk($request->request->get('pk'));
        $isNew = false;
        if ($orderItem === null) {
            $orderItem = new OrderItem();
            // set status created @todo

            $isNew = true;
        }

        $orderItem->setOrderPk($request->request->get('orderPk'));
        $orderItem->setProductPk($request->request->get('productPk'));
        $orderItem->setPrice($orderItem->getProduct()?->getPrice());
        $orderItem->setQuantity($request->request->get('quantity'));
        $orderItem->setNote($request->request->get('note'));

        $validationResponse = JsonValidationResponse::ValidateModel($orderItem);

        if ($validationResponse->getSuccess()) {
            $orderItem->save();
            $this->addFlash(FlashMessageType::SUCCESS, 'Položka bola ' . ($isNew ? 'pridaná' : 'upravená') . '.');
        }

        return $validationResponse->toJsonResponse();
    }
}
