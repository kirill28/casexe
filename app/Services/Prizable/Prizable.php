<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 02.02.19
 * Time: 17:25
 */

namespace App\Services\Prizable;


interface Prizable
{
    /**
     * Checks if prizable item is in limit
     * @return bool
     */
    public function isAvailable(): bool;

    /**
     * @return mixed
     */
    public function getValue();
}