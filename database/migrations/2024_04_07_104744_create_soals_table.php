<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            $table->integer('proyek_id');
            $table->string('nama');
            $table->text('pernyataan');
            $table->text('cover');
            $table->integer('waktu_ujian');
            $table->integer('waktu_feedback');
            $table->timestamp('waktu_akses_ujian')->nullable();
            $table->integer('is_mandiri')->nullable();
            $table->text('token')->nullable();
            $table->timestamp('token_expired')->nullable();
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
        Schema::dropIfExists('soals');
    }
}
