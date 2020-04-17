<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('payables', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('job_id');
			$table->integer('created_by');
			$table->double('payable_amount', 11, 2);
			$table->double('tax_amount', 11, 2);
			$table->tinyInteger('tax_method')->comment('1 for inclusive and 2 for exclusive');
			$table->tinyInteger('tax');
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
		Schema::dropIfExists('payables');
	}

}
