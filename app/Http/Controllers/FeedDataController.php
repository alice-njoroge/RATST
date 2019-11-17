<?php

namespace App\Http\Controllers;

use App\Schema;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use PDO;
use PDOException;

class FeedDataController extends Controller
{
    /**
     * @param $database_name
     * @return PDO
     */
    function get_pdo($database_name)
    {
        $host = config('database.connections.mysql.host');
        $db = $database_name;
        $user = config('database.connections.mysql.username');
        $pass = config('database.connections.mysql.password');
        $port = config('database.connections.mysql.port');
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
        logger($dsn);
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
     * List the tables
     * @param $database
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($database)
    {
        try {
            $pdo = $this->get_pdo($database);
        } catch (\PDOException $e) {
            return response()->json(['message' => 'the database not found. select another database'], 400);
        }
        $statement = $pdo->prepare('show tables');
        $statement->execute();
        $tables = $statement->fetchAll(PDO::FETCH_OBJ);
        return view('pages.feed-data.index', ['tables' => $tables, 'schema' => $database]);
    }

    /**
     * @param $database
     * @param $table_name
     * @return \Illuminate\Http\JsonResponse
     */
    public function feed_data_view($database, $table_name)
    {
        try {
            $pdo = $this->get_pdo($database);
        } catch (\PDOException $e) {
            return response()->json(['message' => 'the database not found. select another database'], 400);
        }
        $sql = 'show fields from ' . $table_name;
        $fields_statement = $pdo->prepare($sql);
        $fields_statement->execute();
        $columns = $fields_statement->fetchAll(PDO::FETCH_OBJ);
        $inside_data = [];
        foreach ($columns as $column) {
            $data_to_push = ['field' => $column->Field, 'type' => $column->Type];
            array_push($inside_data, $data_to_push); // call by reference because they are stacks in the  background
        }
        return view('pages.feed-data.add-data', [
            'table_name' => $table_name,
            'fields' => $inside_data,
            'schema' => $database
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function process_submitted_table_data(Request $request)
    {
        $table_name = $request->input('table_name');
        $database_name = $request->input('schema');
        try {
            $pdo = $this->get_pdo($database_name);
        } catch (\PDOException $e) {
            return response()->json(['message' => 'the database not found. select another database'], 400);
        }
        $sql = 'show fields from ' . $table_name;
        $fields_statement = $pdo->prepare($sql);
        $fields_statement->execute();
        $columns = $fields_statement->fetchAll(PDO::FETCH_OBJ);
        $insert_statement = 'insert into ' . $table_name . '(';
        foreach ($columns as $index => $value) {
            if ($index == (sizeof($columns) - 1)) {
                $insert_statement = $insert_statement . $value->Field . ')';
            } else {
                $insert_statement = $insert_statement . $value->Field . ',';
            }
        }
        $insert_statement = $insert_statement . ' values (';
        foreach ($columns as $index => $value) {
            $key = $value->Field;
            if (strpos($value->Type, 'int') !== false) {
                if ($index == (sizeof($columns) - 1)) {
                    $insert_statement = $insert_statement . (int)$request->$key . ');';
                } else {
                    $insert_statement = $insert_statement . (int)$request->$key . ',';
                }
            } else if (strpos($value->Type, 'float') !== false) {
                if ($index == (sizeof($columns) - 1)) {
                    $insert_statement = $insert_statement . (float)$request->$key . ');';
                } else {
                    $insert_statement = $insert_statement . (float)$request->$key . ',';
                }
            } else {
                if ($index == (sizeof($columns) - 1)) {
                    $insert_statement = $insert_statement . '\'' . $request->$key . '\');';
                } else {
                    $insert_statement = $insert_statement . '\'' . $request->$key . '\', ';
                }
            }
        }
        try {
            $stmt = $pdo->prepare($insert_statement);
            $stmt->execute();
        } catch (PDOException $exception) {
            flash($exception->getMessage())->error();
            return redirect()->back()->withInput();
        }
        if ($request->input('submit') == 'submit and feed another table') {
            flash('Success! your data has been recorded')->success();
            return redirect(route('feed.index', $database_name));
        } else {
            flash('Success! your data has been recorded')->success();
            return redirect(route('feed.data_view', ['database' => $database_name, 'table_name' => $table_name]));
        }
    }
}
