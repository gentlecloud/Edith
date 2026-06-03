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
        Schema::table('edith_menus', function (Blueprint $table) {
            //
            $table->tinyInteger('hide_menu')->default(0)->after('status')->comment('隐藏菜单')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('edith_menus', function (Blueprint $table) {
            //
            $table->dropColumn('hide_menu');
        });
    }
};
