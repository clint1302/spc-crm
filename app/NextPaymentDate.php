<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NextPaymentDate extends Model
{
    protected $fillable = [
        'created_by', 'job_id', 'next_payment_date', 'short_note'
    ];
}
