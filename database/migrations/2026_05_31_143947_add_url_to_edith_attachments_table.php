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
        Schema::table('edith_attachments', function (Blueprint $table) {
            //
            $table->string('channel_id')->default(0)->after('id')->comment('附件通道')->index();
            $table->string('platform_id')->default(0)->after('channel_id')->comment('附件归属平台')->index();
            $table->string('url')->nullable()->after('path')->comment('附件');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('edith_attachments', function (Blueprint $table) {
            //
            $table->dropColumn('channel_id');
            $table->dropColumn('platform_id');
            $table->dropColumn('url');
        });
    }
};
