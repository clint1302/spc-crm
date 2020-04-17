<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallmentsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('installments', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('job_id');
			$table->integer('created_by');
			$table->string('installment_name');
			$table->double('installment_amount', 11, 2);
			$table->string('installment_method')->comment('1 for cash and 2 for check');
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
		Schema::dropIfExists('installments');
	}
}
