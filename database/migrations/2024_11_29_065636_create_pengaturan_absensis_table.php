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
        Schema::create('pengaturan_absensis', function (Blueprint $table) {
            $table->id();
            $table->time('check_in', $precision=1)->nullable();
            $table->time('check_out', $precision=1)->nullable();
            $table->string('rentang_awal_IP', length:50)->nullable();
            $table->string('rentang_akhir_IP', length:50)->nullable();
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
        Schema::dropIfExists('pengaturan_absensis');
    }
};
