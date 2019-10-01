<?php

namespace App\Http\Controllers;

use App\Imports\DataImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ImportFromExcellController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pages.import-excel.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function process_excel_file(Request $request)
    {
        $this->validate($request, [
            'database' => 'required|string',
            'schema_name' => 'required|string',
            'excel_sheet' => 'required|file'
        ]);
        // use the DB facade to create the database in the server
        $name = $request->input('database');
        $select_database = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$name'";

        if (!empty(DB::select($select_database))) {
            $message = 'The database name is already taken. Pick another name for your database';
            flash($message)->error();
            return redirect()->back()->withInput($request->all());
        }

        DB::statement('create database if not exists ' . $request->input('database'));

        session()->put('schema_name', $request->input('schema_name'));
        session()->put('database_name', $request->input('database'));
        Excel::import(new DataImport, $request->file('excel_sheet'));
        flash('Imported excel successfully')->success();
        $redirect_to = route('parser').'/'.$name;
        return redirect($redirect_to);
    }
}
