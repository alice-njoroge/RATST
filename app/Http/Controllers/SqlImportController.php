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
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
        return $pdo;
    }

    public function upload_file(Request $request)
    {
        $this->validate($request, [
            'sql_file' => 'required|file|max:2000',
            'database' => 'required|string'
        ]);
        DB::statement('create database if not exists ' . $request->input('database'));
        $pdo = $this->get_pdo($request->input('database'));
        $pdo->exec(file_get_contents($request->file('sql_file')));

        flash('SQL imported successfully')->success();
        return redirect('/');

    }
}
