<?php

namespace App\Utils\Datafeed;

use App\Model\CustomerQuery;
use App\Model\UserQuery;
use App\Utils\Datafeed\Interfaces\AbstractDatafeed;
use App\Utils\Datafeed\Params\TableOrdersParams;

class FormOrder extends AbstractDatafeed
{
    protected function _prepareData() 
    {
        /** @var TableOrdersParams */
        $params = $this->params;

        $this->data['customers'] = $this->getCustomers();
        $this->data['users'] = $this->getUsers();
    }

    private function getCustomers() {
        return CustomerQuery::create()
            ->orderByLastName()
            ->orderByFirstName()
            ->find();
    }

    private function getUsers() {
        return UserQuery::create()
            ->orderByUsername()
            ->find();
    }

}
