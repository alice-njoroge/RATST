<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schema extends Model
{
    protected $fillable = [
        'name',
        'number_of_attributes'
    ];
}
