<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('repetitions')->nullable();
            $table->unsignedSmallInteger('max_distance')->nullable();
            $table->unsignedSmallInteger('average_distance')->nullable();
            $table->unsignedSmallInteger('max_speed')->nullable();
            $table->unsignedSmallInteger('average_speed')->nullable();
            $table->unsignedSmallInteger('max_power')->nullable();
            $table->unsignedSmallInteger('average_power')->nullable();
            $table->unsignedSmallInteger('kg')->nullable();
            $table->boolean('calculated');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('sessions');
    }
}
