<?php

namespace App\Utils\Datafeed;

use App\Model\OrderQuery;
use App\Utils\Datafeed\Interfaces\AbstractDatafeed;
use App\Utils\Datafeed\Params\ChartRevenueParams;
use DateTime;

class ChartRevenue extends AbstractDatafeed
{
    protected function _getDefaultData()
    {
        $emptySeries = array_fill(0, 13, 0);

        $defData = [
            'params' => null,
            'series' => [
                [
                    'name' => 'Príjmy',
                    'data' => $emptySeries // prijmy po mesiacoch
                ]
            ],
            'xAxis' => [
                'categories' => [] // mesiace
            ],
            'yAxis' => [
                'min' => 0,
                'max' => 100,
            ],
            'sums' => [
                'revenue' => 0,
                'orders' => 0,
            ]
        ];

        return $defData;
    }


    protected function _prepareData()
    {
        /** @var ChartRevenueParams */
        $params = $this->params;
        $this->data['params'] = $params;

        // set xAxis categories - months
        $this->setXAxisCategories();

        // set data to series
        $prijmySeriesIndex = 0;
        foreach ($this->getOrders($params) as $order) {
            $monthIndex = $this->dateTimeToMonthIndex($order->getCreated());
            $price = $order->getRealPrice();

            $this->data['series'][$prijmySeriesIndex]['data'][$monthIndex] += $price;

            $this->data['sums']['revenue'] += $price;
            $this->data['sums']['orders']++;
        }

        // set yAxis max
        $yMax = max($this->data['series'][$prijmySeriesIndex]['data']);
        $this->data['yAxis']['max'] = ceil($yMax / 10) * 10 + 10;
    }

    private function getOrders(ChartRevenueParams $params)
    {
        $query = OrderQuery::create()
            ->filterByCreated([
                'min' => $params->getPeriodFrom()->format('Y-m-d'),
                'max' => $params->getPeriodTo()->format('Y-m-d'),
            ]);

        return $query->find();
    }

    protected function setXAxisCategories()
    {
        /** @var ChartRevenueParams */
        $params = $this->params;

        $periodFrom = $params->getPeriodFrom();
        $periodTo = $params->getPeriodTo();

        $months = [];
        $month = $periodFrom;
        while ($month <= $periodTo) {
            $months[] = $month->format('M y');
            $month = $month->modify('+1 month');
        }

        $this->data['xAxis']['categories'] = $months;
    }

    protected function dateTimeToMonthIndex(DateTime $dateTime)
    {
        /** @var ChartRevenueParams */
        $params = $this->params;

        $periodFrom = $params->getPeriodFrom();
        $periodTo = $params->getPeriodTo();

        $monthIndex = 0;
        $month = $periodFrom;
        while ($month <= $periodTo) {
            if ($month->format('M y') == $dateTime->format('M y')) {
                return $monthIndex;
            }
            $month = $month->modify('+1 month');
            $monthIndex++;
        }

        return $monthIndex;
    }
}
