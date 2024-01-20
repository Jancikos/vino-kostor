<?php

namespace App\Utils\Datafeed\Params;

use App\Utils\Datafeed\Interfaces\IDatafeedParams;

class TableProductsParams implements IDatafeedParams
{
    public const ORDERABLE_COLUMNS = [ 'PK_', 'TITLE', 'SUBTITLE', 'PRICE', 'ACTIVE' ];


    private string $orderColumn;
    private string $orderDirection = 'DESC';


    public function __construct() { }


    public function getOrderColumn(): string
    {
        return $this->orderColumn;
    }

    public function setOrderColumn(string $orderColumn): void
    {
        if (!in_array($orderColumn, self::ORDERABLE_COLUMNS)) {
            throw new \Exception('Neplatný orderColumn pre ProductsTableParams.');
        }

        $this->orderColumn = $orderColumn;
    }

    public function getOrderDirection(): string
    {
        return $this->orderDirection;
    }

    public function setOrderDirection(string $orderDirection): void
    {
        if (!in_array($orderDirection, ['ASC', 'DESC'])) {
            throw new \Exception('Neplatný orderDirection pre ProductsTableParams.');
        }

        $this->orderDirection = $orderDirection;
    }
}