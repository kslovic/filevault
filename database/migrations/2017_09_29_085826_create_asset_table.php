<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset', function (Blueprint $table) {
            $table->increments('aid');
            $table->string('title',200);
            $table->string('mime_type',100);
            $table->bigInteger('size');
            $table->enum('public', ['yes', 'no'])->default('no');
            $table->string('ref',200);
            $table->timestamp('pub_time')->useCurrent();
            $table->integer('downloaded')->default(0);
            $table->integer('uid')->unsigned();

            $table->foreign('uid')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset', function (Blueprint $table) {
            Schema::dropIfExists('asset');
        });
    }
}
