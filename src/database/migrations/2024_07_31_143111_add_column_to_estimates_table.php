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
        Schema::table('estimates', function (Blueprint $table) {
            $table->boolean('issued')->default(0)->after('user_id');
            $table->boolean('ordered')->default(0)->after('issued');
            $table->boolean('on_hold')->default(0)->after('ordered');
            $table->softDeletes()->after('on_hold'); // 論理削除用のカラム
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estimates', function (Blueprint $table) {
            $table->dropColumn('issued');
            $table->dropColumn('ordered');
            $table->dropColumn('on_hold');
            $table->dropSoftDeletes(); // 論理削除用のカラムの削除
        });
    }
};
