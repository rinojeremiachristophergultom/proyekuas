<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user__bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id')->unique();
            $table->string('user_id');
            $table->string('lapangan_id');
            $table->string('tanggal');
            $table->string('lama_mulai');
            $table->string('jam_mulai');
            $table->string('jam_habis');
            $table->string('jenis');
            $table->string('harga_lapangan');
            $table->string('total');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('lapangan_id')->references('lapangan_id')->on('lapangans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user__bookings');
    }
}
