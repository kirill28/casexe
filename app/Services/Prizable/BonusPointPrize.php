<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 02.02.19
 * Time: 21:44
 */

namespace App\Services\Prizable;


use App\Models\SystemOption;
use App\Services\WinResultHelper;

class BonusPointPrize extends Prize
{
    protected $min;

    protected $max;

    public function __construct()
    {
        $optionNames = [
            SystemOption::BONUS_POINTS_MIN_VALUE,
            SystemOption::BONUS_POINTS_MAX_VALUE,
            SystemOption::MONEY_TO_BONUS_POINTS_COEFFICIENT,
        ];

        $options = SystemOption::getValues($optionNames);

        $this->min = $options[SystemOption::BONUS_POINTS_MIN_VALUE];
        $this->max = $options[SystemOption::BONUS_POINTS_MAX_VALUE];
    }

    /**
     * Checks if prizable item is in limit
     * @return bool
     */
    public function isAvailable(): bool
    {
        return isset($this->min) && isset($this->max);
    }

    /**
     * Generates value property
     * @return mixed
     */
    public function generateValue(): void
    {
        $this->value = crypto_rand_int($this->min, $this->max);
    }


    /**
     * @return WinResultHelper
     */
    public function handle(): WinResultHelper
    {
        $value = $this->getValue();
        $user = \Auth::user();

        $user->addBonusPoints($value);

        return new WinResultHelper('casino._bonus_win', compact('value'));
    }
}