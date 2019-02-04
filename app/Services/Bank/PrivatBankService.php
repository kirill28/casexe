<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 03.02.19
 * Time: 18:33
 */

namespace App\Services\Bank;


use App\Models\MoneyTransaction;
use App\Models\SystemOption;
use SimpleXMLElement;

class PrivatBankService extends BankService
{
    const PRIVAT_BANK_API_ENDPOINT = 'https://api.privatbank.ua/p24api';
    const PRIVAT_BANK_API_BALANCE_URI = '/balance';
    const PRIVAT_BANK_API_P2P_URI = '/pay_visa';
    const CURRENCY_UAH = 'UAH';

    protected $merchantId;

    protected $merchantPassword;

    protected $testMode;

    public function __construct()
    {
        $optionNames = [
            SystemOption::PRIVAT_BANK_MERCHANT_ID,
            SystemOption::PRIVAT_BANK_MERCHANT_PASSWORD,
            SystemOption::PRIVAT_BANK_ENABLE_PAYMENTS,
        ];

        try {
            $options = SystemOption::getValues($optionNames);

            $this->apiEndpoint = static::PRIVAT_BANK_API_ENDPOINT;
            $this->merchantId = $options[SystemOption::PRIVAT_BANK_MERCHANT_ID];
            $this->merchantPassword = $options[SystemOption::PRIVAT_BANK_MERCHANT_PASSWORD];
            $this->testMode = $options[SystemOption::PRIVAT_BANK_ENABLE_PAYMENTS] ? 0 : 1;
        } catch (\PDOException $exception) {
            //artisan and composer throw an exception, might be because of abstract parent dependency
        }
    }

    /**
     * @param string $uri
     * @param string $xmlBody
     * @return string
     */
    protected function requestApi(string $uri, string $xmlBody): string
    {
        $url = $this->apiEndpoint . $uri;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: text/xml']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlBody);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * Makes request to an api and sets the $balance value
     */
    protected function syncBalance(): void
    {
        $data = view('xml_templates.privat_bank.data')->render();
        $sign = sha1(md5($data.$this->merchantPassword));
        $xml = view('xml_templates.privat_bank.body', [
            'merchantId' => $this->merchantId,
            'sign' => $sign,
            'data' => $data,
        ])->render();

        $response = $this->requestApi(static::PRIVAT_BANK_API_BALANCE_URI, $xml);

        /** @var SimpleXMLElement $object */
        $object = simplexml_load_string($response);
        $balanceObject = $object->data->info->cardbalance->av_balance;
        $balance = (double) ((array) $balanceObject)[0];

        $this->balance = $balance;
    }

    /**
     * @param MoneyTransaction $moneyTransaction
     * @return bool
     * @throws \Throwable
     */
    public function processTransaction(MoneyTransaction $moneyTransaction): bool
    {
        $currency = $moneyTransaction->currency ?? static::CURRENCY_UAH;

        $data = view('xml_templates.privat_bank.data', [
            'test' => $this->testMode,
            'wait' => 5,
            'paymentId' => $moneyTransaction->id,
            'cardNumber' => $moneyTransaction->card_number,
            'amount' => $moneyTransaction->amount,
            'currency' => $currency,
            'userName' => $moneyTransaction->user->name,
        ])->render();

        $sign = sha1(md5($data.$this->merchantPassword));

        $xml = view('xml_templates.privat_bank.body', [
            'merchantId' => $this->merchantId,
            'sign' => $sign,
            'data' => $data,
        ])->render();

        $response = $this->requestApi(static::PRIVAT_BANK_API_P2P_URI, $xml);
        $object = simplexml_load_string($response);
        $attributesObject = $object->data->payment;
        $attributes = array_first((array) $attributesObject);

        $moneyTransaction->info = $attributes;

        if ((int) $attributes['state'] === 1) {
            $moneyTransaction->status = MoneyTransaction::STATUS_SUCCESS;
        } else {
            $moneyTransaction->status = MoneyTransaction::STATUS_ERROR;
        }

        return $moneyTransaction->save();
    }

    /**
     * @return string
     */
    public static function getDefaultCurrency():string
    {
        return static::CURRENCY_UAH;
    }
}