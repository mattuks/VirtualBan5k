<?php

namespace App\Http\Controllers;

/**
 * Class AccountController
 * @package App\Http\Controllers
 */
class AccountController extends Controller
{
    public function index()
    {
        return view('transfer');
    }
}
