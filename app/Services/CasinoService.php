<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 02.02.19
 * Time: 17:07
 */

namespace App\Services;


use App\Services\Prizable\BonusPointPrize;
use App\Services\Prizable\ItemPrize;
use App\Services\Prizable\MoneyPrize;
use App\Services\Prizable\Prizable;

class CasinoService
{
    protected $prizes;

    public function __construct()
    {
        $prizes = [
            new BonusPointPrize(),
            new MoneyPrize(),
            new ItemPrize(),
        ];

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

    public function getPrize(): Prizable
    {
        $index = crypto_rand_int(0, count($this->prizes) - 1);
        /** @var Prizable $prize */
        $prize = $this->prizes[$index];

        return $prize;
    }
}