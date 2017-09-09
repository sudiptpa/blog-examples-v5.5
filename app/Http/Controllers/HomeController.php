<?php

namespace App\Http\Controllers;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    public function home()
    {
        return view('welcome');
    }
}
