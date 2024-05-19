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
        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            // $table->integer('proyek_id');
            $table->string('nama');
            $table->text('pernyataan');
            $table->text('cover');
            $table->integer('waktu_ujian');
            $table->string('batch');
            $table->timestamp('waktu_akses_ujian')->nullable();
            $table->integer('is_mandiri')->nullable();
            $table->text('token')->nullable();
            $table->integer('is_share');
            $table->integer('created_by');
            $table->integer('is_deleted')->default(false);
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
};
