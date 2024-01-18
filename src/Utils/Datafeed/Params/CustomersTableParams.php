<?php

namespace App\Utils\Datafeed\Params;

use App\Utils\Datafeed\Interfaces\IDatafeedParams;

class CustomersTableParams implements IDatafeedParams
{
    public const ORDERABLE_COLUMNS = [ 'PK_', 'NAME', 'ADDRESS' ];


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
            throw new \Exception('Neplatný orderColumn pre CustomersTableParams.');
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
            throw new \Exception('Neplatný orderDirection pre CustomersTableParams.');
        }

        $this->orderDirection = $orderDirection;
    }
}