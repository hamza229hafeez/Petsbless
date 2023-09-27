<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('services', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('type');
        //     $table->string('title');
        //     $table->text('listing_summary');
        //     $table->text('description');
        //     $table->decimal('price', 10, 2);
        //     $table->string('location');
        //     $table->string('country');
        //     $table->string('city');
        //     $table->string('zipcode');
        //     $table->string('street_number');
        //     $table->string('user_id'); // Changed the type to string
        //     $table->foreign('user_id')->references('id')->on('users');  // Assuming 'users' is your users table.
        //     $table->timestamps();
        // });
        
        // Schema::create('service_questions', function (Blueprint $table) {
        //     $table->id();
        //     $table->text('question');
        //     $table->text('answer')->nullable();
        //     $table->foreignId('service_id')->constrained('services');
        //     $table->timestamps();
        // });
        
        // Schema::create('service_images', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('url');
        //     $table->foreignId('service_id')->constrained('services');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_images');
    }
};
