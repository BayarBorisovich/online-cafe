<?php

namespace App\Http\Controllers;


use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\View;

class MainController extends Controller
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
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function main(): View
    {
        return view('main.index');
    }
}
