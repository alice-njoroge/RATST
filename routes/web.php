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
// design your own database
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

Route::get('/database-designs/feed-data/tables/{database}', 'FeedDataController@index')
    ->name('feed.index');

Route::get('/database-designs/feed-data/tables/{database}/{table_name}', 'FeedDataController@feed_data_view')
    ->name('feed.data_view');
Route::post('/database-designs/process-feed-data', 'FeedDataController@process_submitted_table_data')
    ->name('feed.process_submitted_table_data');

//import from excel
Route::get('/import-from-excel', 'ImportFromExcellController@index')->name('import_from_excel');
Route::post('/import-from-excel', 'ImportFromExcellController@process_excel_file')->name('process_excel_file');
//import from sql
Route::get('/slqdump', 'SqlImportController@index')->name('import');
Route::post('/slqdump', 'SqlImportController@upload_file')->name('upload');
//parser data
Route::get('/databases', 'AlreadyDefinedDatabasesController@list_databases')->name('databases');
Route::get('/databases/tables_fields/{database}', 'AlreadyDefinedDatabasesController@schema_fields');

//help controller
Route::get('/help', 'HelpController@index')->name('learn-more');
Route::get('/select', 'HelpController@selection')->name('select');
Route::get('/project', 'HelpController@projection')->name('project');
Route::get('/rename', 'HelpController@rename')->name('rename');
Route::get('/union', 'HelpController@union')->name('union');
Route::get('/set-difference', 'HelpController@difference')->name('diff');
Route::get('/intersection', 'HelpController@intersection')->name('intersection');
Route::get('/product', 'HelpController@product')->name('product');
Route::get('/join', 'HelpController@join')->name('join');
Route::get('/about-the-developer', 'HelpController@about_the_developer')->name('about_the_developer');

// this line must be last
Route::get('/{database?}', 'ParserController@index')->name('parser');
Route::post('/execute', 'ParserController@execute')->name('execute_parser');
Route::post('/show-sample-data', 'ParserController@sample_data')->name('sample_data');
