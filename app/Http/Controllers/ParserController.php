<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParserController extends Controller
{
    /**
     * List the editor, the databases and the tables.
     * @param string $database
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($database = 'themepark')
    {
        return view('pages.parser.index', ['database' => $database, 'container_fluid' => true]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function execute(Request $request)
    {
        $results = view('pages.parser.tabular-results')->render();
        return response()->json($results);
    }

}
