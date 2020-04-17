<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsSetting extends Model
{
    protected $fillable=['sms_from','api_key','routeid', 'url'];
}
