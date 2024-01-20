<?php

namespace App\Utils\Datafeed;

use App\Model\ProductQuery;
use App\Utils\Datafeed\Interfaces\AbstractDatafeed;
use App\Utils\Datafeed\Params\TableProductsParams;

class TableProducts extends AbstractDatafeed
{
    protected function _prepareData() 
    {
        /** @var TableProductsParams */
        $params = $this->params;

        $this->data['params'] = $params;
        $this->data['products'] = $this->getProducts();
    }

    private function getProducts() {
        /** @var TableProductsParams */
        $params = $this->params;

        $query = ProductQuery::create();

        switch ($params->getOrderColumn()) {
            case 'PK_':
                $query->orderByPk($params->getOrderDirection());
                break;
            case 'TTILE':
                $query->orderByTitle($params->getOrderDirection());
                break;
            case 'SUBTITLE':
                $query->orderBySubtitle($params->getOrderDirection());
                break;
            case 'PRICE':
                $query->orderByPrice($params->getOrderDirection());
                break;
            case 'ACTIVE':
                $query->orderByActive($params->getOrderDirection());
                break;
        }

        return $query->find();
    }
}
