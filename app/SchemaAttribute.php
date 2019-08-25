<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchemaAttribute extends Model
{
    /**
     * mass assignable field
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'size',
        'null',
        'index',
        'primary_key',
        'schema_id'
    ];
}
