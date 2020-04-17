<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $fillable = [
        'created_by', 'job_id', 'installment_name', 'installment_amount', 'installment_method', 'short_note'
    ];
}
