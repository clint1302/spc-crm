<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomInvoiceDetails extends Model
{
    protected $fillable = [
        'invoice_id', 'sl', 'description', 'subtotal'
    ];
}
