<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchemaAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schema_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('type');
            $table->unsignedInteger('size')->nullable();
            $table->boolean('null')->default(0);
            $table->boolean('index')->default(0);
            $table->boolean('primary_key')->default(0);
            $table->unsignedBigInteger('schema_id');

            $table->foreign('schema_id')->on('schemas')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schema_attributes');
    }
}
