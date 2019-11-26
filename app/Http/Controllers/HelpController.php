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
    public function projection()
    {
        return view('pages.help.projection', ['container_fluid' => true]);
    }

    public function rename()
    {
        return view('pages.help.rename', ['container_fluid' => true]);
    }

    public function union()
    {
        return view('pages.help.union', ['container_fluid' => true]);
    }

    public function difference()
    {
        return view('pages.help.difference', ['container_fluid' => true]);
    }

    public function intersection()
    {
        return view('pages.help.intersection', ['container_fluid' => true]);
    }

    public function product()
    {
        return view('pages.help.product', ['container_fluid' => true]);
    }

    public function join()
    {
        return view('pages.help.join', ['container_fluid' => true]);
    }

    public function about_the_developer()
    {
        return view('pages.help.about-the-developer');
    }

}
