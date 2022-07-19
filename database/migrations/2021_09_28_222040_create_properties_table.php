<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('category_id');
            $table->integer('city_id')->nullable();
            $table->string('property_name', 200);
            $table->text('description')->nullable();
            $table->string('address', 200)->nullable();
            $table->string('checkin_time', 100)->nullable();
            $table->string('checkout_time', 100)->nullable();
            $table->integer('total_rooms')->default(0);
            $table->string('total_area_sqft', 100)->nullable();
            $table->string('total_halls', 100)->nullable();
            $table->string('total_washrooms', 100)->nullable();
            $table->string('daily_price', 100);
            $table->string('weekend_price', 100)->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('owner_name', 255)->nullable();
            $table->string('owner_image', 255)->nullable();
            $table->integer('status')->default(1)->comment("1=Active,0=Inactive"); 
            $table->integer('edited_by'); 
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('properties_images', function (Blueprint $table) {
            $table->id();
            $table->integer('property_id'); 
            $table->string('image_name', 200); 
            $table->integer('status')->default(1)->comment("1=Active,0=Inactive");
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('properties_features', function (Blueprint $table) {
            $table->id();
            $table->integer('property_id');
            $table->integer('feature_id');  
            $table->integer('status')->default(1)->comment("1=Active,0=Inactive"); 
            $table->integer('created_by');
            $table->integer('edited_by');  
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
        Schema::dropIfExists('properties_images');
        Schema::dropIfExists('properties_features');
    }
}
