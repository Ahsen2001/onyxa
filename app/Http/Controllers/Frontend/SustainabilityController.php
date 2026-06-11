<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SustainabilityController extends Controller
{
    public function index(): View
    {
        return view('frontend.sustainability.index');
    }
}
