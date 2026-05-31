<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('edith_attachment_channels', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('platform_id')->default(0)->unsigned()->index();
            $table->string('channel_type', 64);
            $table->string('access_id', 64);
            $table->string('access_secret', 64);
            $table->string('endpoint', 64)->nullable();
            $table->string('bucket', 64)->nullable();
            $table->string('domain')->nullable();
            $table->boolean('status')->default(1);
            $table->string('remark', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('edith_attachment_channels');
    }
};
