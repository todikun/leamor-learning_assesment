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
        Schema::create('soal_details', function (Blueprint $table) {
            $table->id();
            $table->integer('soal_id');
            $table->integer('tipe_soal_id');
            $table->longText('pertanyaan');
            $table->longText('stimulus');
            $table->longText('opsi_jawaban');
            $table->text('kunci_jawaban');
            $table->integer('skor');
            $table->longText('feedback')->nullable();
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
        Schema::dropIfExists('soal_details');
    }
};
