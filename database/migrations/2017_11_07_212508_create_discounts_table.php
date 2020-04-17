<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('discounts', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('job_id');
			$table->integer('created_by');
			$table->double('discount_amount', 11, 2);
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
		Schema::dropIfExists('discounts');
	}
}
