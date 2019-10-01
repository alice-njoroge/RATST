<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;
use PDO;
use PDOException;

class DataImport implements ToCollection
{
    /**
     * helper function to get pdo instance
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
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
        return $pdo;
    }

    /**
     * creating the table and insert data
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $pdo = $this->get_pdo(session()->get('database_name'));
        $create_statement = 'create table if not exists ' . session()->get('schema_name') . '(';
        foreach ($collection[0] as $index => $item) {
            if ($index != sizeof($collection[0]) - 1) { //
                $create_statement = $create_statement . Str::slug($item, '_') . ' varchar(255),';
            } else {
                $create_statement = $create_statement . Str::slug($item, '_') . ' varchar(255)';
            }
        }
        $create_statement = $create_statement . ');';
        $pdo->exec($create_statement);

//        insert data into the table

        $insert_statement = 'insert into ' . session()->get('schema_name') . ' values';
        foreach (array_slice($collection->toArray(), 1) as $index => $item) {
            if (empty($item[0])) {
                continue;
            }
            // loop thru the columns in that row
            $insert_statement = $insert_statement . ' ( ';
            foreach ($item as $second_index => $second_item) {
                if ($second_index != sizeof($item) - 1) {
                    $insert_statement = $insert_statement . '"' . $second_item . '"' . ',';
                } else {
                    $insert_statement = $insert_statement . '"' . $second_item . '"' . '),';
                }
            }
        }
        $insert_statement = substr_replace($insert_statement, ';', -1);
        $pdo->exec($insert_statement);
    }
}
