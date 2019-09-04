<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParserController extends Controller
{
    public function index($database = 'themepark')
    {
        return view('pages.parser.index', ['database' => $database, 'container_fluid' => true]);
    }
}
