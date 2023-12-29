<?php

namespace App\Utils\Orders;

use App\Model\Map\OrderTableMap;
use App\Model\Order;
use Propel\Runtime\Map\TableMap;

class OrderStatusManager
{
    private static array $statuses = [];

    private static function initializeStatuses()
    {
        self::$statuses = [
            OrderStatusCase::CREATED->value => new OrderStatus(
                OrderStatusCase::CREATED,
                'Vytvorená',
                OrderTableMap::COL_CREATED
            ),
            OrderStatusCase::PACKED->value => new OrderStatus(
                OrderStatusCase::PACKED,
                'Zabalená',
                OrderTableMap::COL_PACKED
            ),
            OrderStatusCase::SHIPPED->value => new OrderStatus(
                OrderStatusCase::SHIPPED,
                'Doručená',
                OrderTableMap::COL_SHIPPED
            ),
            OrderStatusCase::PAIED->value => new OrderStatus(
                OrderStatusCase::PAIED,
                'Zaplatená',
                OrderTableMap::COL_PAIED
            )
        ];
    }

    /** @return array<OrderStatus>  */
    public static function getStatuses(): array
    {
        if (empty(self::$statuses)) {
            self::initializeStatuses();
        }

        return self::$statuses;
    }

    public static function getStatus(int $pk): OrderStatus
    {
        return self::getStatuses()[$pk];
    }

    public static function setOrderStatus(Order $order, OrderStatusCase $statusCase): void
    {
        $statusPk = $statusCase->value;
        $now = new \DateTime();

        foreach (self::getStatuses() as $pk => $status) {
            // vsetky nasledujuce stavy musia byt prazdne
            if ($pk > $statusPk) {
                $order->setByName($status->getTableColumn(), null, TableMap::TYPE_COLNAME);
                continue;
            }

            // vsetky predchadzajuce stavy musia byt vyplnene
            if ($pk < $statusPk) {
                if ($order->getByName($status->getTableColumn(), TableMap::TYPE_COLNAME) !== null) {
                    continue;
                }
            }

            $order->setByName($status->getTableColumn(), $now, TableMap::TYPE_COLNAME);
        }
        $order->setStatus($statusPk);
    }


}
