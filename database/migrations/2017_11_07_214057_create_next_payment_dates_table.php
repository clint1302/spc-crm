<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNextPaymentDatesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('next_payment_dates', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('job_id');
			$table->integer('created_by');
			$table->date('next_payment_date');
			$table->string('short_note')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('next_payment_dates');
	}
}
