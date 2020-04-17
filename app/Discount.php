<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'created_by', 'job_id', 'discount_amount', 'short_note'
    ];
}
