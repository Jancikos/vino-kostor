<?php

namespace App\Utils\Datafeed;

use App\Model\OrderQuery;
use App\Model\Product;
use App\Utils\Datafeed\Interfaces\AbstractDatafeed;
use App\Utils\Datafeed\Params\ChartUnpackedProductsParams;
use App\Utils\Orders\OrderStatusCase;

class ChartUnpackedProducts extends AbstractDatafeed
{
    /** @var array pkcko produktu a jeho index v datach grafu */
    private array $productsPks = [];

    protected function _getDefaultData()
    {
        $defData = [
            'params' => null,
            'series' => [], 
            'labels' => [], // labels for series
            'colors' => [], // colors for series
            'sums' => [
                'total' => 0
            ]
        ];

        return $defData;
    }


    protected function _prepareData()
    {
        /** @var ChartUnpackedProductsParams */
        $params = $this->params;
        $this->data['params'] = $params;

        
        foreach ($this->getOrders($params) as $order) {
            foreach ($order->getOrderItems() as $item) {
                $product = $item->getProduct();
                $index = $this->getProductIndex($product);
                $quantity = $item->getQuantity();

                $this->data['series'][$index] += $quantity;
                $this->data['sums']['total'] += $quantity;
            }
        }
    }

    private function getProductIndex(Product $product)
    {
        if (!array_key_exists($product->getPk(), $this->productsPks)) {
            $this->productsPks[$product->getPk()] = count($this->data['labels']);
            
            $this->data['series'][] = 0;
            $this->data['labels'][] = $product->getTitle();
            $this->data['colors'][] = $this->getRandomColor(); // zatial produkt nema farbu
        }        
        
        return $this->productsPks[$product->getPk()];
    }

    /**
     * Generate random color in hex format
     * @return string 
     */
    private function getRandomColor()
    {
        $letters = '0123456789ABCDEF';
        $color = '#';
        for ($i = 0; $i < 6; $i++)
        {
            $color .= $letters[rand(0, 15)];
        }

        return $color;
    }

    private function getOrders(ChartUnpackedProductsParams $params)
    {
        $query = OrderQuery::create()
            ->filterByStatus(OrderStatusCase::CREATED->value);

        if ($params->getAdminPk() > 0) {
            $query->filterByUserPk($params->getAdminPk());
        }

        return $query->find();
    }
}
