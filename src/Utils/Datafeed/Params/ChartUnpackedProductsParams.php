<?php

namespace App\Utils\Datafeed\Params;

use App\Utils\Datafeed\Interfaces\IDatafeedParams;

class ChartUnpackedProductsParams implements IDatafeedParams
{
    private int $adminPk = 0; 

    public function __construct() {
      
     }

    public function getAdminPk(): int
    {
        return $this->adminPk;
    }

    public function setAdminPk(int $adminPk): void
    {
        $this->adminPk = $adminPk;
    }
}