<?php

namespace App\Http\Controllers;

use App\DesignDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class DesignedDatabasesController extends Controller
{
    /**
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

    /**
     * List the schemas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $databases = DesignDatabase::all();
        return view('pages.schemas.index', ['databases' => $databases]);
    }

    /**
     * Create Database
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create_database()
    {
        return view('pages.schemas.create-schema-step-one');
    }

    public function store_database(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'number_of_tables' => 'required'
        ]);

        $name = $request->input('name');
        $select_database = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$name'";

        if (!empty(DB::select($select_database))) {
            $message = 'The database name is already taken';
            flash($message)->error();
            return redirect()->back()->withInput($request->all());
        }
        \DB::statement("create database " . $name);
        DesignDatabase::create(['name' => $name]);
        $request->session()->put('database_name', $name);
        $request->session()->put('database_number_tables', $request->input('number_of_tables'));
        return redirect(route('create_tables'));
    }

    public function create_tables(Request $request)
    {
        $number_of_tables = (int)$request->session()->get('database_number_tables', 1);
        return view('pages.schemas.table_names', ['no_tables' => $number_of_tables]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function process_create_tables(Request $request)
    {
        $this->validate($request, [
            'tables.*.name' => 'required',
            'tables.*.number_of_fields' => 'required',
        ]);

        $tables = collect($request->input('tables'));
        $table_names = $tables->map(function ($item, $key) {
            return $item['name'];
        });

        $unique_names = array_unique($table_names->toArray()); // get unique names
        $duplicate_keys_assoc = array_diff_assoc($table_names->toArray(), $unique_names); // differentiate main array from the unique array
        $duplicate_names = array_values($duplicate_keys_assoc); // remove the names from the associative array
        if (sizeof($duplicate_names) > 0) { // message formatting using commas where duplicates are more than one
            $message = 'tables ';
            foreach ($duplicate_names as $key => $value) {
                if ($key == 0) {
                    $message = 'table ' . $value;
                } else {
                    $message = $message . ',' . $value;
                }
            }
            $message = $message . ' duplicated. Please fix this';
            flash($message)->error();
            return redirect()->back()->withInput($request->all());
        }
        $request->session()->put('tables', $tables->toArray());
        return redirect(route('create_fields'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create_fields(Request $request)
    {
        if (!$request->session()->has('current_table')) {
            $request->session()->put('current_table', 1);
        } else {
            $current_table = (int)$request->session()->get('current_table');
            $request->session()->put('current_table', $current_table + 1);
        }

        return view('pages.schemas.table_fields');
    }

    public function process_create_fields(Request $request)
    {
        $this->validate($request, [
            'fields.*.name' => 'required|string',
            'fields.*.type' => 'required|string',
        ]);

        $fields = collect($request->input('fields'));
        $names = $fields->map(function ($item, $key) {
            return $item['name'];
        });
        $unique_names = array_unique($names->toArray()); // get unique names
        $duplicate_keys_assoc = array_diff_assoc($names->toArray(), $unique_names); // differentiate main array from the unique array
        $duplicate_names = array_values($duplicate_keys_assoc); // remove the names from the associative array
        if (sizeof($duplicate_names) > 0) { // message formatting using commas where duplicates are more than one
            $message = '';
            foreach ($duplicate_names as $key => $value) {
                if ($key == 0) {
                    $message = $value;
                } else {
                    $message = $message . ',' . $value;
                }
            }
            $message = $message . ' are duplicates. Please fix this';
            flash($message)->error();
            return redirect()->back()->withInput($request->all());
        }
        $data = [];
        $database_name = $request->session()->get('database_name');
        $current_table_index = (int)$request->session()->get('current_table');
        $table_name = $request->session()->get('tables')[$current_table_index]['name'];
        $table_no_of_columns = $request->session()->get('tables')[$current_table_index]['number_of_fields'];
        foreach ($fields as $attribute) {
            $attribute['size'] = (int)$attribute['size'];
            $attribute['null'] = array_key_exists('null', $attribute) ? 1 : 0;
            $attribute['index'] = array_key_exists('index', $attribute) ? 1 : 0;
            $attribute['primary_key'] = array_key_exists('primary_key', $attribute) ? 1 : 0;
            array_push($data, $attribute);
        }
        $this->create_table($database_name, $table_name, $table_no_of_columns, $fields);
        $tables = $request->session()->get('tables');
        $tables[$current_table_index]['fields'] = $fields;
        $request->session()->put('tables', $tables);
        if (sizeof($tables) != $current_table_index) {
            return redirect(route('create_fields'));
        }
        return redirect('/');
    }

    /**
     * @param $database_name
     * @param $table_name
     * @param $no_columns
     * @param $fields
     */
    function create_table($database_name, $table_name, $no_columns, $fields)
    {
        $index = 1;
        $sql_statement = "create table if not exists " . $table_name . "(";
        foreach ($fields as $field) {
            $sql_statement = $sql_statement . $field['name'] . ' ' . $field['type'];
            if ($field['size'] > 0) {
                $sql_statement = $sql_statement . '(' . $field['size'] . ')';
            }

            if (array_key_exists('null', $field)) {
                $sql_statement = $sql_statement . ' null';
            } else {
                $sql_statement = $sql_statement . ' not null';
            }
            if (array_key_exists('primary_key', $field)) {
                $sql_statement = $sql_statement . ' primary key';
            }
            if ($no_columns != $index) {
                $sql_statement = $sql_statement . ',';
            }
            $index++;
        }
        $sql_statement = $sql_statement . ');';
        $pdo = $this->get_pdo($database_name);
        $pdo->exec($sql_statement);
        foreach ($fields as $field) {
            if (array_key_exists('index', $field)) {
                $index_statements = 'create index ';
                $index_statements = $index_statements . $field['name'] . ' on ' . $table_name . '(' . $field['name'] . ');';
                $pdo->exec($index_statements);
            }
        }
    }

    /**
     * @param Request $request
     * @param $database_name
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public
    function delete_database(Request $request, $database_name)
    {
        DB::statement("drop database if exists " . $database_name);
        DesignDatabase::where('name', $database_name)->delete();
        $request->session()->forget([
            'database_name',
            'database_number_tables',
            'tables',
            'current_table'
        ]);
        flash('Removed database')->success();
        return redirect(route('design_databases'));
    }
}
