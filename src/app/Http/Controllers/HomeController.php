<?php

namespace App\Http\Controllers;

use App\Models\Customer;

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

     * @return View(見積作成画面)
     */
    public function index()
    {
        $customers = Customer::all();
        return view('home', compact('customers'));
    }
}
