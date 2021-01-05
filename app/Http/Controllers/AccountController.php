<?php

namespace App\Http\Controllers;

use App\Account;
use App\Factories\AccountFactory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $account = AccountFactory::create([
            'user_id' => auth()->id(),
            'currency' => $request['currency'],
            'name' => $request['currency'].' Account',
        ]);
        $account->save();

        return redirect('/home');
    }


}
