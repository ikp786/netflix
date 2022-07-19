<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('property_id');
            $table->integer('user_id');
            $table->string('first_name', 200)->nullable();
            $table->string('last_name', 200)->nullable();
            $table->string('email', 200)->nullable();
            $table->string('phone', 200)->nullable();
            $table->string('id_proof', 300)->nullable();
            $table->timestamp('checkin_date')->nullable();
            $table->timestamp('checkout_date')->nullable(); 
            $table->integer('adults');
            $table->integer('childs');
            $table->integer('infants');
            $table->text('booking_comments')->nullable(); 
            $table->enum('booking_status', array('0','1','2','3','4','5'))->comment("0=pending, 1=confirmed, 2=canclled, 3=refunded, 4=rejected,5=completed");
            $table->string('transaction_id', 200)->nullable();
            $table->integer('no_of_days')->default(0);
            $table->string('total_amount', 100);
            $table->string('gst', 200)->nullable();
            $table->string('additional_charges', 200)->nullable();
            $table->string('grand_total', 200);
            $table->string('payment_status', 200)->nullable();
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
        Schema::dropIfExists('bookings');
    }
}
