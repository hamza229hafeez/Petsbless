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
        Schema::create('users', function (Blueprint $table) {
            $table->string('id')->primary(); // Creates an auto-incrementing 'id' column as the primary key
            $table->string('username')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('profilepicture')->nullable();
            $table->string('contactnumber')->nullable();
            $table->text('address')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->boolean('userstatus')->default(false);
            $table->timestamps();
        });
    
            Schema::create('pets', function (Blueprint $table) {
                $table->id();
                $table->string('pettype');
                $table->string('petbreed');
                $table->string('petsize');
                $table->string('petgender');
                $table->date('dateofbirth');
                $table->string('petowner'); // Foreign key column
    
                // Define the foreign key constraint
                $table->foreign('petowner')->references('id')->on('users')->onDelete('cascade');
    
                $table->timestamps();
            });
            Schema::create('pet_photos', function (Blueprint $table) {
                $table->id();
                $table->string('photo_url');
                $table->unsignedBigInteger('petid'); // Foreign key column
    
                // Define the foreign key constraint
                $table->foreign('petid')->references('id')->on('pets')->onDelete('cascade');
    
                $table->timestamps();
            });
            Schema::create('pet_posts', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->string('userid'); // Foreign key column
    
                // Define the foreign key constraint
                $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
    
                $table->timestamps();
            });
            Schema::create('pet_post_photos', function (Blueprint $table) {
                $table->id();
                $table->string('photo_url');
                $table->unsignedBigInteger('postid'); // Foreign key column
    
                // Define the foreign key constraint
                $table->foreign('postid')->references('id')->on('pet_posts')->onDelete('cascade');
    
                $table->timestamps();
            });
            Schema::create('jobs', function (Blueprint $table) {
                $table->id();
                $table->string('service_type');
                $table->date('start_date');
                $table->date('end_date');
                $table->string('service_location');
                $table->text('description');
                $table->boolean('pickup_service');
                $table->string('user_id'); // Changed data type to string
                $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('pets');
    }
};
