<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('category');
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
            $table->text('memo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
