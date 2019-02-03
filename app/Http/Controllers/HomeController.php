<?php

namespace App\Http\Controllers;

use App\Services\CasinoService;
use App\Services\WinResultHelper;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param CasinoService $casinoService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(CasinoService $casinoService)
    {
        $gameIsAvailable = $casinoService->hasPrizes();

        /** @var WinResultHelper|null $winResult */
        $winResult = session()->get('winResult');

        return view('home', compact('gameIsAvailable', 'winResult'));
    }
}
