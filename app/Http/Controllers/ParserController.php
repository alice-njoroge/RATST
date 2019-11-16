<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PDO;
use Throwable;

class ParserController extends Controller
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

    private function rename_operation(Array $result, string $database_name)
    {
        if (array_key_exists('new_relation_name', $result)) {
        } else {
            $table_name = $result['relation_name'];
            $new_column_name = $result['new_attribute_name'];
            $old_column_name = $result['old_attribute_name'];
            $pdo = $this->get_pdo($database_name);
            $stmt = $pdo->query("show columns from " . $table_name);
            $columns = $stmt->fetchAll();
            $key = array_search($old_column_name, array_column($columns, 'Field'));
            $data_type = $columns[$key]['Type'];
            //Create sql column update statement
            $update_sql = "alter table {$table_name} change {$old_column_name} {$new_column_name} {$data_type}";
            $pdo->exec($update_sql);
            $database_results = [
                [
                    'Key' => 'Table',

                    'Value' => $table_name
                ],
                [
                    'Key' => 'Old Column Name',

                    'Value' => $old_column_name
                ],
                [
                    'Key' => 'New  Column Name',

                    'Value' => $new_column_name
                ],
            ];
            return [
                'database_results' => $database_results,
                'sql_out' => $update_sql . ';'
            ];
        }
        return [];
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function execute(Request $request)
    {
        $this->validate($request, [
            'database_name' => 'required',
            'query' => 'required'
        ]);
        $database_name = $request->input('database_name');
        //initialize new  guzzle client with url
        $client = new Client([
            'base_uri' => 'localhost:5000',
        ]);
        $response = $client->request('GET', '/', [
            'query' => ['query' => $request->input('query')]
        ]);
        $result = json_decode((string)$response->getBody(), true);
        if (gettype($result['result']) == 'array') {
            $result = $this->rename_operation($result['result'], $database_name);
            $database_results = $result['database_results'];
            $sql_output = $result['sql_out'];
        } else {
            $pdo = $this->get_pdo($database_name);
            $stmt = $pdo->query($result['result']); // run the query against the initialized pdo
            $database_results = $stmt->fetchAll(); // fetch db results
            $sql_output = $result['result'] . ";";
        }
        $results = view('pages.parser.tabular-results', [
            'database_results' => $database_results,
            'sql_output' => $sql_output
        ])->render();
        return response()->json($results);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sample_data(Request $request)
    {
        $this->validate($request, [
            'database_name' => 'required',
            'table_name' => 'required'
        ]);
        $database_name = $request->input('database_name');
        $table_name = $request->input('table_name');
        $pdo = $this->get_pdo($database_name);
        $sql = 'show fields from ' . $table_name;
        $fields_statement = $pdo->prepare($sql);
        $fields_statement->execute();
        $columns = $fields_statement->fetchAll(PDO::FETCH_OBJ);
        $select_sql = 'select * from ' . $table_name . ' limit 10';
        $select_statement = $pdo->prepare($select_sql);
        $select_statement->execute();
        $data = $select_statement->fetchAll(PDO::FETCH_NUM);
        return response()->json([
            'columns' => $columns,
            'data' => $data
        ]);
    }

    /**
     * List the editor, the databases and the tables.
     * @param string $database
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($database = 'themepark')
    {
        return view('pages.parser.index', ['database_name' => $database, 'container_fluid' => true]);
    }

}
