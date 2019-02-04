<?php

namespace App\Http\Controllers;

use App\Models\ItemTransaction;
use App\Models\MoneyTransaction;
use App\Services\CasinoService;
use App\Services\Prizable\BonusPointPrize;
use App\Services\WinResultHelper;
use Illuminate\Http\Request;

class CasinoController extends Controller
{
    protected $casino;

    /**
     * CasinoController constructor.
     * @param CasinoService $casino
     */
    public function __construct(CasinoService $casino)
    {
        $this->middleware('auth');

        $this->casino = $casino;
    }

    public function play()
    {
        if (!$this->casino->hasPrizes()) {
            return redirect()->back();
        }

        $prize = $this->casino->getPrize();

        /** @var WinResultHelper $result */
        $result = $prize->handle();

        if ($result->persist) {
            session()->put('winResult', $result);
        } else {
            session()->flash('winResult', $result);
        }

        return redirect()->back();
    }

    public function convertToBonus(MoneyTransaction $moneyTransaction)
    {
        if ($moneyTransaction->user_id !== \Auth::id()) {
            return redirect()->back();
        }

        $value = $moneyTransaction->amount;
        $moneyTransaction->delete();
        $prize = new BonusPointPrize();
        $result = $prize->convertFromMoney($value);
        session()->flash('winResult', $result);

        return redirect()->back();
    }

    public function applyMoneyTransaction(Request $request, $transactionId)
    {
        $validator = \Validator::make($request->all(), [
            'card_number' => 'required|digits:16',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->toArray());
        }

        $moneyTransaction = MoneyTransaction::find($transactionId);
        $moneyTransaction->card_number = $request->get('card_number');
        $moneyTransaction->status = MoneyTransaction::STATUS_PENDING;
        $moneyTransaction->save();

        session()->forget('winResult');

        return redirect()->back();
    }

    public function rejectItemTransaction($transactionId)
    {
        $itemTransaction = ItemTransaction::find($transactionId);
        $item = $itemTransaction->item;

        $item->available_count++;
        $item->save();
        $itemTransaction->delete();

        session()->forget('winResult');

        return redirect()->back();
    }

    public function applyItemTransaction($transactionId)
    {
        $itemTransaction = ItemTransaction::find($transactionId);
        $itemTransaction->status = ItemTransaction::STATUS_PENDING;
        $itemTransaction->save();

        session()->forget('winResult');

        return redirect()->back();
    }
}
