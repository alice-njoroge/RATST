<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParserController extends Controller
{
    public function index()
    {
        return view('pages.parser.index');
    }
}
