<?php

namespace App\Utils\Orders;

class OrderStatus
{
    private OrderStatusCase $pk;
    private string $title;
    private string $tableColumn;

    public function __construct(OrderStatusCase $pk, string $title, string $tableColumn)
    {
        $this->pk = $pk;
        $this->title = $title;
        $this->tableColumn = $tableColumn;
    }

    public function getPk(): OrderStatusCase
    {
        return $this->pk;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTableColumn(): string
    {
        return $this->tableColumn;
    }
}
