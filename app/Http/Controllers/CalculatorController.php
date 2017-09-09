<?php

namespace App\Http\Controllers;

/**
 * Class CalculatorController
 * @package App\Http\Controllers
 */
class CalculatorController extends Controller
{
    public function calculator()
    {
        return view('calculator');
    }
}
