<?php

namespace App\Utils\Orders;

enum OrderStatusCase : int
{
    case CREATED = 1;
    case PACKED = 2;
    case SHIPPED = 3;
    case PAIED = 4;
}
