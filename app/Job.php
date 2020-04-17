<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model {

    protected $fillable = [
        'name_of_account', 'created_by', 'job_type','client','auto_kenteken','job_time', 'reference_by', 'assign_to','assign_to_second','receiving_date', 'description', 'publication_status', 'job_status'
    ];

}
