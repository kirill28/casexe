<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 04.02.19
 * Time: 18:38
 */

namespace App\Services\Prizable;


use App\Models\Item;
use App\Models\ItemTransaction;
use App\Services\WinResultHelper;

class ItemPrize implements Prizable
{
    protected $value;

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
        $item = Item::where('available_count', '>', 0)
            ->first();
        return isset($item);
    }

    /**
     * Generates value property
     * @return mixed
     */
    public function generateValue(): void
    {
        $ids = \DB::table('items')
            ->where('available_count', '>', 0)
            ->pluck('id')
            ->toArray();
        $index = crypto_rand_int(0, count($ids) - 1);
        $id = $ids[$index];

        $this->value = Item::find($id);
    }

    /**
     * @return WinResultHelper
     */
    public function handle(): WinResultHelper
    {
        /** @var Item $value */
        $value = $this->getValue();

        $transaction = new ItemTransaction([
            'item_id' => $value->id,
            'user_id' => \Auth::id(),
            'status' => ItemTransaction::STATUS_WAITING,
        ]);
        $transaction->save();
        $transactionId = $transaction->id;

        $value->available_count--;
        $value->save();

        $result = new WinResultHelper('casino._item_win', compact('value', 'transactionId'));
        $result->persist = true;
        return $result;
    }
}