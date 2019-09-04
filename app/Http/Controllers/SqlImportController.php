<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class SqlImportController extends Controller
{
    public function index()
    {

        return view('pages.sql-import.index');
    }

    /**
     *  return a pdo object which will be used to operate on the database
     * pdo is equivalent to mysqli but provides a uniform API on top of databases
     * @param $database_name
     * @return PDO
     */
    function get_pdo($database_name)
    {
        $host = env('DB_HOST');
        $db = $database_name;
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');
        $port = env('DB_PORT');
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // choose failure with response not silently
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // return results in associative array
            PDO::ATTR_EMULATE_PREPARES => false, // dont prepare statements automatically to avoid sql injection attacks
        ];
//try to create a new pdo object but if there is an error catch and throw an exception
        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
        return $pdo; // return pdo object if there was no error
    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function upload_file(Request $request)
    {
        $this->validate($request, [
            'sql_file' => 'required|file|max:2000',
            'database' => 'required|string'
        ]);
        // use the DB facade to create the database in the server
        DB::statement('create database if not exists ' . $request->input('database'));
        $pdo = $this->get_pdo($request->input('database')); // cal get pdo to get a new pdo instance
        $pdo->exec(file_get_contents($request->file('sql_file'))); // execute the sql file against the database

        flash('SQL imported successfully')->success();
        return redirect('/');

    }
}
