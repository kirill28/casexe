<?php

namespace App\Http\Controllers;

use App\Services\CasinoService;
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

        return view('home', compact('gameIsAvailable'));
    }
}
