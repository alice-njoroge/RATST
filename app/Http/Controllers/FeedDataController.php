<?php

namespace App\Http\Controllers;

use App\Schema;
use Illuminate\Http\Request;

class FeedDataController extends Controller
{
    public function index(Schema $schema)
    {
        return view('pages.feed-data.index', ['schema' => $schema]);
    }
}
