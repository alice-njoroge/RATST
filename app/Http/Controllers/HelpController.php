<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function index()
    {
        return view('pages.help.index', ['container_fluid' => true]);
    }
    public function selection()
    {
        return view('pages.help.selection', ['container_fluid' => true]);
    }
}
