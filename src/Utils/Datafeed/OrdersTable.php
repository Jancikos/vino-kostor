<?php

namespace App\Utils\Datafeed;

use App\Model\OrderQuery;
use App\Utils\Datafeed\Interfaces\AbstractDatafeed;
use App\Utils\Datafeed\Params\OrdersTableParams;

class OrdersTable extends AbstractDatafeed
{
    protected function _prepareData() 
    {
        /** @var OrdersTableParams */
        $params = $this->params;

        $this->data['params'] = $params;
        $this->data['orders'] = $this->getOrders();
    }

    private function getOrders() {
        /** @var OrdersTableParams */
        $params = $this->params;

        $query = OrderQuery::create();

        switch ($params->getOrderColumn()) {
            case 'PK_':
                $query->orderByPk($params->getOrderDirection());
                break;
            case 'STATUS':
                $query->orderByStatus($params->getOrderDirection());
                break;
            case 'USER_PK_':
                $query
                    ->useUserQuery()
                        ->orderByUsername($params->getOrderDirection())
                    ->endUse();
                break;
            case 'TOTAL_PRICE':
                // TODO
                throw new \Exception('Not implemented yet.');
                break;
        }

        return $query->find();
    }
}
