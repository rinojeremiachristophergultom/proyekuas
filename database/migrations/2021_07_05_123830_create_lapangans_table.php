<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLapangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lapangans', function (Blueprint $table) {
            $table->id();
            $table->string('lapangan_id')->unique();
            $table->string('nama');
            $table->text('keterangan');
            $table->string('harga_siang');
            $table->string('harga_malam');
            $table->string('foto1');
            $table->string('foto2')->nullable();
            $table->string('foto3')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('lapangans');
    }
}
