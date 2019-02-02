<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 02.02.19
 * Time: 17:07
 */

namespace App\Services;


use App\Services\Prizable\Prizable;

class CasinoService
{
    protected $prizes;

    public function __construct()
    {
        $prizes = [];

        $prizes = array_filter($prizes, function (Prizable $prize) {
            return $prize->isAvailable();
        });

        $this->prizes = $prizes;
    }

    /**
     * @return bool
     */
    public function hasPrizes(): bool
    {
        return count($this->prizes);
    }

    public function getPrize()
    {
        $index = crypto_rand_int(0, count($this->prizes) - 1);
        $prize = $this->prizes[$index];
        //TODO
    }


}