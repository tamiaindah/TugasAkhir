<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->text('kode_transaksi');
            $table->unsignedBigInteger('customer_id');
            $table->string('kurir');
            $table->string('service');
            $table->bigInteger('ongkir');
            $table->integer('berat');
            $table->string('nama');
            $table->bigInteger('no_hp');
            $table->integer('provinsi');
            $table->integer('kota');
            $table->text('alamat');
            $table->enum('status', array('pending', 'sukses', 'gagal', 'expired'));
            $table->bigInteger('total');
            $table->string('snap_token');
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
        Schema::dropIfExists('transaksis');
    }
}
