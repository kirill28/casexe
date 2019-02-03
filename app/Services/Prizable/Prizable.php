<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 02.02.19
 * Time: 17:25
 */

namespace App\Services\Prizable;


use App\Services\WinResultHelper;

interface Prizable
{
    /**
     * Checks if prizable item is in limit
     * @return bool
     */
    public function isAvailable(): bool;

    /**
     * Generates value property
     * @return mixed
     */
    public function generateValue(): void;

    /**
     * Returns value property
     * @return mixed
     */
    public function getValue();

    /**
     * @return WinResultHelper
     */
    public function handle(): WinResultHelper;
}