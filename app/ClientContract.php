<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientContract extends Model
{
    protected $fillable = [
        'id', 'name', 'time'
    ];
}
