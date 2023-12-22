<?php

namespace App\Model;

use App\Model\Base\Customer as BaseCustomer;
use App\Utils\Validation\IValidableModel;

/**
 * Skeleton subclass for representing a row from the 'customer' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Customer extends BaseCustomer implements IValidableModel
{

    public function getFullName() : string {
        return $this->getSurname() . ' ' . $this->getName();
    }
}
