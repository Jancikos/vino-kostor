<?php

namespace App\Utils\Datafeed;

use App\Model\OrderQuery;
use App\Utils\Datafeed\Interfaces\AbstractDatafeed;
use App\Utils\Datafeed\Params\TableOrdersParams;

class TableOrders extends AbstractDatafeed
{
    protected function _prepareData() 
    {
        /** @var TableOrdersParams */
        $params = $this->params;

        $this->data['params'] = $params;
        $this->data['orders'] = $this->getOrders();
    }

    private function getOrders() {
        /** @var TableOrdersParams */
        $params = $this->params;

        $query = OrderQuery::create();

        switch ($params->getOrderColumn()) {
            case 'PK_':
                $query->orderByPk($params->getOrderDirection());
                break;
            case 'CUSTOMER':
                $query
                    ->useCustomerQuery()
                        ->orderByLastName($params->getOrderDirection())
                        ->orderByFirstname()
                    ->endUse();
                break;
            case 'STATUS':
                $query->orderByStatus($params->getOrderDirection());
                break;
            case 'ADMIN':
                $query
                    ->useUserQuery()
                        ->orderByUsername($params->getOrderDirection())
                    ->endUse();
                break;
                break;
        }

        return $query->find();
    }
}
