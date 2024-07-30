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
        Schema::create('estimate_item', function (Blueprint $table) {
            $table->integer('estimate_id');
            $table->integer('version');
            $table->integer('item_id');
            $table->integer('diff');
            $table->integer('acc');
            $table->integer('cost');
            $table->integer('risk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimate_item');
    }
};
