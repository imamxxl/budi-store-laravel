<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
            $table->integer('quantity')->nullable();
            $table->integer('discount')->nullable();
            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('transaksi_id')->nullable();
            $table->foreign('transaksi_id')->references('id')->on('transaksis')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tmps');
    }
}
