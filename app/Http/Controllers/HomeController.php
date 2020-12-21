<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\User;
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
     * Show the application dashboard.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $account = Account::findOrFail(auth()->id());
        return view('home')->with('account', $account);
    }

}
