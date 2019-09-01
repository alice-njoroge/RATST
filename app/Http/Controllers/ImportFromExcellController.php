<?php

namespace App\Http\Controllers;

use App\Imports\DataImport;
use Illuminate\Http\Request;
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
            'schema_name' => 'required|string',
            'excel_sheet' => 'required|file'
        ]);
        session()->push('schema_name', $request->input('schema_name'));
        Excel::import(new DataImport, $request->file('excel_sheet'));
        flash('imported successfully')->success();
        return redirect()->back();
    }
}
