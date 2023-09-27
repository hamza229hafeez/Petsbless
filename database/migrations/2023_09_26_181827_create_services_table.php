<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      
        Schema::create('pet_for_job', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('pet_id');
            $table->timestamps();

            // Define foreign keys
            $table->foreign('job_id')->references('id')->on('jobs');
            $table->foreign('pet_id')->references('id')->on('pets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job');
    }
}

