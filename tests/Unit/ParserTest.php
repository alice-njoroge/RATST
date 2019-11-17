<?php

namespace Tests\Unit;

use PDO;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParserTest extends TestCase
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
     * Parser page unit test
     *
     * @return void
     */
    public function testParserIndex()
    {
        $response = $this->get('/themepark');
        $response->assertStatus(200);
    }

    /**
     * Test if you can fetch sample data successfully
     */
    public function testFetchSampleData()
    {
        $response = $this->json('POST', '/show-sample-data', [
            'database_name' => 'themepark',
            'table_name' => 'attraction'
        ]);

        $pdo = $this->get_pdo('themepark');
        $sql = 'show fields from attraction';
        $fields_statement = $pdo->prepare($sql);
        $fields_statement->execute();
        $columns = $fields_statement->fetchAll(PDO::FETCH_ASSOC);
        $select_sql = 'select * from attraction limit 10';
        $select_statement = $pdo->prepare($select_sql);
        $select_statement->execute();
        $data = $select_statement->fetchAll(PDO::FETCH_NUM);
        $response
            ->assertStatus(200)
            ->assertJson([
                'columns' => $columns,
                'data' => $data
            ]);
    }
}
