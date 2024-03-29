<?php

namespace App\Model;

use App\Model\Base\Product as BaseProduct;
use App\Utils\Validation\IValidableModel;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Skeleton subclass for representing a row from the 'product' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Product extends BaseProduct implements IValidableModel
{

    public function getEncodedImage(): string
    {
        $image = $this->getImage();
        if ($image === null) {
            return '';
        }

        $imageData = '';
        if (is_resource($image)) {
            $imageData = stream_get_contents($image);
        }
        return base64_encode($imageData);
    }
}
