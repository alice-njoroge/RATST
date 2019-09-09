<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/database-designs', 'DesignedDatabasesController@index')->name('design_databases');
Route::get('/remove-database/{database_name}', 'DesignedDatabasesController@delete_database')->name('remove_database');
Route::get('/database-designs/create_database', 'DesignedDatabasesController@create_database')->name('create_database');
Route::post('/database-designs/create_database', 'DesignedDatabasesController@store_database')
    ->name('store_database');
Route::get('/database-designs/create_tables', 'DesignedDatabasesController@create_tables')
    ->name('create_tables');
Route::post('/database-designs/create_tables', 'DesignedDatabasesController@process_create_tables')
    ->name('process_create_tables');

Route::get('/database-designs/create-fields', 'DesignedDatabasesController@create_fields')
    ->name('create_fields');
Route::post('/database-designs/create-fields', 'DesignedDatabasesController@process_create_fields')
    ->name('process_create_fields');


Route::get('/import-from-excel', 'ImportFromExcellController@index')->name('import_from_excel');
Route::post('/import-from-excel', 'ImportFromExcellController@process_excel_file')->name('process_excel_file');
Route::get('/slqdump', 'SqlImportController@index')->name('import');
Route::post('/slqdump', 'SqlImportController@upload_file')->name('upload');

Route::get('/feed-data/{schema}', 'FeedDataController@index')->name('feed-data');
Route::get('/databases', 'AlreadyDefinedDatabasesController@list_databases')->name('databases');
Route::get('/databases/tables_fields/{database}', 'AlreadyDefinedDatabasesController@schema_fields');

// this line must be last
Route::get('/{database?}', 'ParserController@index')->name('parser');
