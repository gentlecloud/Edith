<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('edith_settings', function (Blueprint $table) {
            $table->string('flag', 64);
            $table->json('value')->nullable();
            $table->timestamps();
            $table->primary('flag');
        });

        Schema::create('edith_modules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('模块标识');
            $table->string('title')->comment('模块名称');
            $table->string('description')->nullable()->comment('模块简介');
            $table->string('author')->nullable()->comment('模块开发者');
            $table->string('website')->nullable()->comment('模块开发官网');
            $table->integer('priority')->default(0)->comment('加载顺序');
            $table->boolean('status')->default(1)->comment('模块状态0 已禁用 1已启用');
            $table->string('mode')->default('local')->comment('模块运行模式 Local 本地模块 Cloud 云服务模块');
            $table->string('version')->default('1.0.0')->comment('模块版本');
            $table->dateTime('expired_at')->nullable()->comment('模块到期时间');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('edith_modules');
        Schema::dropIfExists('edith_settings');
    }

    /**
     * 填充初始数据
     * @return void
     */
    public function fillInitialData()
    {

    }
};