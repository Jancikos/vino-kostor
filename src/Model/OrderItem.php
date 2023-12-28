<?php

namespace App\Model;

use App\Model\Base\OrderItem as BaseOrderItem;
use App\Utils\Validation\IValidableModel;

/**
 * Skeleton subclass for representing a row from the 'order_item' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class OrderItem extends BaseOrderItem implements IValidableModel
{

    /**
     * @return float celkova suma polozky
     * @throws PropelException 
     */
    public function getTotalPrice() : float {
        return $this->getQuantity() * $this->getPrice();
    }
}
