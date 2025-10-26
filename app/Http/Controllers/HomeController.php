<?php

namespace App\Http\Controllers;

use App\Models\PricingPlan;

class HomeController extends Controller
{
    public function index()
    {
        $plans = PricingPlan::all(); // fetch all plans from DB
        return view('home', compact('plans'));
    }  
}
