<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_of_account');
            $table->integer('created_by');
            $table->integer('job_type');
            $table->integer('client');
            $table->integer('reference_by');
            $table->integer('assign_to');
            $table->date('receiving_date');
            $table->text('description');
            $table->tinyInteger('publication_status');
            $table->tinyInteger('job_status')->default(0);
            $table->tinyInteger('deletion_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
