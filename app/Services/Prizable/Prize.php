<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 02.02.19
 * Time: 21:44
 */

namespace App\Services\Prizable;

abstract class Prize implements Prizable
{
    protected $value;

    public function getValue()
    {
        if (is_null($this->value)) {
            static::generateValue();
        }
        return $this->value;
    }
}