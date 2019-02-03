<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 03.02.19
 * Time: 18:30
 */

namespace App\Services\Bank;


abstract class BankService
{
    protected $apiEndpoint;

    protected $balance;

    /**
     * Makes request to an api and sets the $balance value
     */
    abstract protected function syncBalance(): void;

    /**
     * @return double|null
     */
    public function getBalance(): ?float
    {
        if (is_null($this->balance)) {
            $this->syncBalance();
        }

        return $this->balance;
    }

    /**
     * @return string
     */
    abstract public static function getDefaultCurrency():string;
}