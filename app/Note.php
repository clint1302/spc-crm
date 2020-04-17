<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model {

    protected $fillable = [
        'id','created_by', 'job_id', 'title', 'note', 'remind_date','remind_time'
    ];

}
