<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store()
    {
        $this->middleware('guest')->except('logout');
    }
}
