<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBayarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user__bayars', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id');
            $table->string('user_id');
            $table->string('tanggal');
            $table->string('bukti_tf');
            $table->string('tanggal_upload');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('booking_id')->references('booking_id')->on('user__bookings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user__bayars');
    }
}
