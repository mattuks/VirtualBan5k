<?php

namespace App\Http\Controllers;

use App\Account;
use App\Factories\AccountFactory;
use http\Client\Curl\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Money\Currency;
use Illuminate\Http\Request;
/**
 * Class AccountController
 * @package App\Http\Controllers
 */
class AccountController extends Controller
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
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('open');
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $account = AccountFactory::create([
            'user_id' => auth()->id(),
            'currency' => $request['currency'],
            'name' => 'Account',
        ]);
        $account->save();
    }
}
