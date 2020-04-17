<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryType extends Model
{
    protected $fillable = [
        'id', 'enquiry_type_title', 'publication_status','deletion_status','created_at','updated_at'
    ];
}
