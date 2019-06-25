<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 03.02.19
 * Time: 18:24
 */

namespace App\Services\Prizable;


use App\Models\MoneyTransaction;
use App\Models\SystemOption;
use App\Services\Bank\PrivatBankService;
use App\Services\WinResultHelper;
use Illuminate\Support\Collection;

class MoneyPrize implements Prizable
{
    protected $value;

    protected $min;

    protected $max;

    /**
     * @var PrivatBankService
     */
    protected $bankService;

    public function __construct()
    {
        $optionNames = [
            SystemOption::MONEY_MIN_VALUE,
            SystemOption::MONEY_MAX_VALUE,
        ];

        $options = SystemOption::getValues($optionNames);

        $this->min = $options[SystemOption::MONEY_MIN_VALUE];
        $this->max = $options[SystemOption::MONEY_MAX_VALUE];

        $this->bankService = new PrivatBankService();
    }

    /**
     * Returns value property
     * @return mixed
     */
    public function getValue()
    {
        if (is_null($this->value)) {
            static::generateValue();
        }
        return $this->value;
    }

    /**
     * Checks if prizable item is in limit
     * @return bool
     */
    public function isAvailable(): bool
    {
        $isAvailable = isset($this->min) && isset($this->max);

        if ($isAvailable) {
            $cardBalance = $this->bankService->getBalance();
            $isAvailable = $cardBalance >= $this->min;
        }
        if ($isAvailable) {
            /** @var Collection $transactions */
            $transactions = \DB::table('money_transactions')->whereIn('status', [
                MoneyTransaction::STATUS_PENDING,
                MoneyTransaction::STATUS_WAITING,
            ])->select(['amount', 'currency'])->get();
            //todo add currency checking
            $blocked = $transactions->sum('amount');
            $isAvailable = ($cardBalance - $blocked) >= $this->min;
        }

        return $isAvailable;
    }

    /**
     * Generates value property
     * @return mixed
     */
    public function generateValue(): void
    {
        $max = min($this->max, $this->bankService->getBalance());
        $this->value = crypto_rand_int($this->min, $max);
    }


    /**
     * @return WinResultHelper
     */
    public function handle(): WinResultHelper
    {
        $value = $this->getValue();
        $currency = $this->bankService->getDefaultCurrency();

        $transaction = new MoneyTransaction([
            'user_id' => \Auth::id(),
            'status' => MoneyTransaction::STATUS_WAITING,
            'amount' => $value,
            'currency' => $currency,
        ]);
        $transaction->save();
        $transactionId = $transaction->id;

        $convertCoefficient = SystemOption::getValue(SystemOption::MONEY_TO_BONUS_POINTS_COEFFICIENT);

        $result = new WinResultHelper('casino._money_win',
            compact('value', 'currency', 'transactionId', 'convertCoefficient'));
        $result->persist = true;
        return $result;
    }
}