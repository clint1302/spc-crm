<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomInvoice extends Model {
	protected $fillable = [
		'created_by', 'invoice_type', 'date', 'reference_no', 'invoice_no', 'invoice_name', 'subject', 'address_one', 'address_two', 'contact_no', 'email_address', 'short_note', 'payment_method', 'discount', 'tax', 'paid_amount',
	];
}
