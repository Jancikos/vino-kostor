<?php

namespace App\Model;

use App\Model\Base\Order as BaseOrder;
use App\Utils\Validation\IValidableModel;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Skeleton subclass for representing a row from the 'order' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Order extends BaseOrder implements IValidableModel
{

    
    /**
     * @return int celkovy pocet produktov v objednavke
     * @throws PropelException 
     */
    public function getProductsQuantity() : int {
        $total = 0;

        foreach ($this->getOrderItems() as $item) {
            $total += $item->getQuantity();
        }

        return $total;
    }

    /**
     * @return float celkova suma objednavky
     * @throws PropelException 
     */
    public function getTotalPrice() : float {
        $total = 0;

        foreach ($this->getOrderItems() as $item) {
            $total += $item->getTotalPrice();
        }

        return $total;
    }

    public function preDelete(?ConnectionInterface $con = null): bool
    {
        foreach ($this->getOrderItems() as $item) {
            $item->delete();
        }

        return true;
    }
}
