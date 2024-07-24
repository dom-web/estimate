<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_settings', function (Blueprint $table) {
            $table->integer('diff_low');
            $table->integer('diff_mid');
            $table->integer('diff_high');
            $table->integer('acc_low');
            $table->integer('acc_mid');
            $table->integer('acc_high');
            $table->integer('cost_low');
            $table->integer('cost_mid');
            $table->integer('cost_high');
            $table->integer('risk_low');
            $table->integer('risk_mid');
            $table->integer('risk_high');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('default_settings');
    }
}
