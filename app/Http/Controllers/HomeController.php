<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends FrontController
{
    public function index(){
        return view('pages.main', $this->data);
    }
}
