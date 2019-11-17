<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use PDO;

class AlreadyDefinedDatabasesController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function list_databases()
    {
        $data = [];
        $databases = DB::select('show databases');
        foreach ($databases as $database) {
            if ($database->Database != 'mysql' && $database->Database != 'sys' && $database->Database != 'information_schema' && $database->Database != 'performance_schema') {
                array_push($data, ['database' => $database->Database]);
            }
        }
        return response()->json($data);
    }

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
     * return a json endpoint of tables and their column names and types
     * @param $database
     * @return \Illuminate\Http\JsonResponse
     */
    public function schema_fields($database)
    {
        $key = "Tables_in_" . $database; // object method for the database
        $data = [];
        try {
            $pdo = $this->get_pdo($database);
        } catch (\PDOException $e) {
            return response()->json(['message' => 'the database not found. select another database'], 400);
        }
        $statement = $pdo->prepare('show tables');
        $statement->execute();
        $schemas = $statement->fetchAll(PDO::FETCH_OBJ);
        foreach ($schemas as $schema) {
            if ($schema->$key != 'migrations' && $schema->$key != 'users' && $schema->$key != 'password_resets' && $schema->$key != 'schema_attributes' && $schema->$key != 'schemas') {
                $inside_data = [];
                $sql = 'show fields from ' . $schema->$key;
                $fields_statement = $pdo->prepare($sql);
                $fields_statement->execute();
                $columns = $fields_statement->fetchAll(PDO::FETCH_OBJ);
                foreach ($columns as $column) {
                    $data_to_push = ['field' => $column->Field, 'type' => $column->Type];
                    array_push($inside_data, $data_to_push); // call by reference because they are stacks in the  background
                }
                $outside_data_to_push = ['table' => $schema->$key, 'columns' => $inside_data];
                array_push($data, $outside_data_to_push);
            }
        }
        return response()->json($data);
    }


}
