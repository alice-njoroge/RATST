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
        //initialize new  guzzle client with url
        $client = new Client([
            'base_uri' => 'localhost:5000',
        ]);
        $response = $client->request('GET', '/', [
            'query' => ['query' => $request->input('query')]
        ]);
        $result = json_decode((string)$response->getBody(), true);
        $pdo = $this->get_pdo($request->input('database_name'));
        $stmt = $pdo->query($result['result']); // run the query against the initialized pdo
        $database_results = $stmt->fetchAll(); // fetch db results
        $results = view('pages.parser.tabular-results', [
            'database_results' => $database_results,
            'sql_output' => $result['result'].";"
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
