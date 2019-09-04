<?php

namespace App\Http\Controllers;

use App\Schema;
use App\SchemaAttribute;
use DB;
use Illuminate\Http\Request;
use PDO;

class SchemaController extends Controller
{
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
     * return a json endpoint of tables and their column names and types
     * @param $database
     * @return \Illuminate\Http\JsonResponse
     */
    public function schema_fields($database)
    {
        $key = "Tables_in_" . $database;
        $data = [];
        $pdo = $this->get_pdo($database);
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

    /**
     * List the schemas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $schemas = Schema::all();
        return view('welcome', ['schemas' => $schemas]);
    }

    /**
     * display the step 1
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_schema_step_one_view()
    {
        return view('pages.schemas.create-schema-step-one');
    }

    /**
     * display the step 1
     * @param Schema $schema
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_schema_step_two_view(Schema $schema)
    {
        return view('pages.schemas.create-schema-step-two', ['schema' => $schema]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function process_step_one(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:schemas,name',
            'number_of_attributes' => 'required|numeric'
        ]);

        $schema = Schema::create([
            'name' => $request->input('name'),
            'number_of_attributes' => $request->input('number_of_attributes')
        ]);
        return redirect(route('add-schema-step-2', $schema->id));
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function process_step_two(Request $request)
    {
        $this->validate($request, [
            'attributes.*.name' => 'required|unique:schema_attributes,name',
            'attributes.*.type' => 'required|string',
        ]);
        $attributes = collect($request->input('attributes'));
        $names = $attributes->map(function ($item, $key) {
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
        foreach ($attributes as $attribute) {
            $attribute['schema_id'] = (int)$request->input('schema_id');
            $attribute['size'] = (int)$attribute['size'];
            $attribute['null'] = array_key_exists('null', $attribute) ? 1 : 0;
            $attribute['index'] = array_key_exists('index', $attribute) ? 1 : 0;
            $attribute['primary_key'] = array_key_exists('primary_key', $attribute) ? 1 : 0;
            array_push($data, $attribute);
        }
        SchemaAttribute::insert($data);
        $schema = Schema::find($request->input('schema_id'));
        $this->parse_to_sql($schema);
        return redirect('/');
    }


    /**
     * remove the schema
     * @param Schema $schema
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Schema $schema)
    {
        $schema->delete();
        flash('schema deleted successfully')->success();
        return redirect()->back();
    }

    public function parse_to_sql(Schema $schema)
    {
        $index = 1;
        $sql_statement = "create table if not exists " . $schema->name . "(";
        foreach ($schema->attributes as $attribute) {
            $sql_statement = $sql_statement . $attribute->name . ' ' . $attribute->type;
            if ($attribute->size > 0) {
                $sql_statement = $sql_statement . '(' . $attribute->size . ')';
            }
            if ($attribute->null) {
                $sql_statement = $sql_statement . ' null';
            } else {
                $sql_statement = $sql_statement . ' not null';
            }
            if ($attribute->primary_key) {
                $sql_statement = $sql_statement . ' primary key';
            }
            if ($schema->number_of_attributes != $index) {
                $sql_statement = $sql_statement . ',';
            }

            $index++;
        }
        $sql_statement = $sql_statement . ');';
        DB::statement($sql_statement);
        foreach ($schema->attributes as $attribute) {
            if ($attribute->index) {
                $index_statements = 'create index ';
                $index_statements = $index_statements . $attribute->name . ' on ' . $schema->name . '(' . $attribute->name . ');';
                DB::statement($index_statements);
            }
        }
    }
}
