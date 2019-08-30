<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SqlImportController extends Controller
{
    public function index()
    {

        return view('pages.sql-import.index');
    }

    public function upload_file(Request $request)
    {
        $this->validate($request, [
            'sql_file' => 'required|file|max:2000'
        ]);
        DB::unprepared(file_get_contents($request->file('sql_file')));
        flash('SQL imported successfully')->success();
        return redirect('/');


    }
}
