<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;

class DataImport implements ToCollection
{
    /**
     * creating the table and insert data
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $create_statement = 'create table if not exists ' . session()->get('schema_name')[0] . '(';
        foreach ($collection[0] as $index => $item) {
            if ($index != sizeof($collection[0]) - 1) {
                $create_statement = $create_statement . Str::slug($item, '_') . ' varchar(255),';
            } else {
                $create_statement = $create_statement . Str::slug($item, '_') . ' varchar(255)';
            }
        }
        $create_statement = $create_statement . ');';
        DB::statement($create_statement); //abstraction on top of PDO

//        insert data into the table

        $insert_statement = 'insert into ' . session()->get('schema_name')[0] . ' values';
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
        DB::statement($insert_statement);
    }
}
