<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMeasurements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sessions', function (Blueprint $table) {
            $table->float('kg')->nullable();
            $table->float('max_acceleration')->nullable();
            $table->float('avg_acceleration')->nullable();
            $table->float('max_force')->nullable();
            $table->float('avg_force')->nullable();
            $table->float('max_power')->nullable();
            $table->float('avg_power')->nullable();
        });
        Schema::table('distances', function (Blueprint $table) {
            $table->float('acceleration')->nullable();
            $table->float('force')->nullable();
            $table->float('power')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sessions', function (Blueprint $table) {
            $table->dropColumn([
                'kg','max_acceleration','avg_acceleration',
                'max_force','avg_force','max_power','avg_power'
            ]);
        });
        Schema::table('distances', function (Blueprint $table) {
            $table->dropColumn(['acceleration','force','power']);
        });
    }
}
