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

Route::get('/', 'SchemaController@index');
Route::get('/import-from-excel', 'ImportFromExcellController@index')->name('import_from_excel');
Route::post('/import-from-excel', 'ImportFromExcellController@process_excel_file')->name('process_excel_file');
Route::get('/database/tables_fields', 'SchemaController@schema_fields');
Route::get('/slqdump', 'SqlImportController@index')->name('import');
Route::post('/slqdump', 'SqlImportController@upload_file')->name('upload');
Route::get('schema/remove/{schema}', 'SchemaController@remove')->name('remove-schema');
Route::get('schema/add/step1', 'SchemaController@add_schema_step_one_view')->name('add-schema-step-1');
Route::get('schema/add/step2/{schema}', 'SchemaController@add_schema_step_two_view')->name('add-schema-step-2');
Route::post('schema/add/step1', 'SchemaController@process_step_one')->name('process-step-1');
Route::post('schema/add/step2', 'SchemaController@process_step_two')->name('process-step-2');

Route::get('/feed-data/{schema}', 'FeedDataController@index')->name('feed-data');
Route::get('parser', 'ParserController@index')->name('parser');
