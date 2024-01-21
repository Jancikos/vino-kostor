<?php

namespace App\Utils\Datafeed;

use App\Model\ProductQuery;
use App\Utils\Datafeed\Interfaces\AbstractDatafeed;
use Propel\Runtime\ActiveQuery\Criteria;

class ProductsListPublic extends AbstractDatafeed
{
    protected function _prepareData() 
    {
        $this->data = $this->getProducts();
    }

    private function getProducts() {
        return ProductQuery::create()
            ->filterByActive(1)
            ->orderByPk(Criteria::DESC)
            ->find();
    }
}
