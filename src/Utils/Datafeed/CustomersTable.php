<?php

namespace App\Utils\Datafeed;

use App\Model\CustomerQuery;
use App\Utils\Datafeed\Interfaces\AbstractDatafeed;
use App\Utils\Datafeed\Params\CustomersTableParams;

class CustomersTable extends AbstractDatafeed
{
    protected function _prepareData() 
    {
        /** @var CustomersTableParams */
        $params = $this->params;

        $this->data['params'] = $params;
        $this->data['customers'] = $this->getCustomers();
    }

    private function getCustomers() {
        /** @var CustomersTableParams */
        $params = $this->params;

        $query = CustomerQuery::create();

        switch ($params->getOrderColumn()) {
            case 'PK_':
                $query->orderByPk($params->getOrderDirection());
                break;
            case 'NAME':
                $query->orderByFirstName($params->getOrderDirection());
                $query->orderByLastName($params->getOrderDirection());
                break;
            case 'ADDRESS':
                $query->orderByCity($params->getOrderDirection());
                $query->orderByAddress($params->getOrderDirection());
                break;
        }

        return $query->find();
    }
}
