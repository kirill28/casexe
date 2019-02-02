<?php

namespace App\Http\Controllers;

use App\Services\CasinoService;
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
        //TODO
    }
}
