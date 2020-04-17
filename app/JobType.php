<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobType extends Model {

    protected $fillable = [
        'created_by', 'job_type', 'publication_status', 'job_type_description'
    ];

}
