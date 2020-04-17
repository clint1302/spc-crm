<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomInvoicesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('custom_invoices', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('created_by');
			$table->tinyInteger('invoice_type')->comment('1 for Invoice, 2 for Bill');
			$table->date('date');
			$table->string('reference_no', 100);
			$table->string('invoice_no', 100);
			$table->string('invoice_name', 100);
			$table->string('subject')->nullable();
			$table->string('address_one');
			$table->string('address_two');
			$table->string('contact_no', 20)->nullable();
			$table->string('short_note')->nullable();
			$table->string('email_address', 100)->nullable();
			$table->tinyInteger('payment_method')->comment('1 for Cash, 2 for Check');
			$table->string('discount', 20)->nullable()->default(0);
			$table->string('tax', 20)->nullable()->default(0);
			$table->string('paid_amount', 20)->nullable()->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('custom_invoices');
	}
}
