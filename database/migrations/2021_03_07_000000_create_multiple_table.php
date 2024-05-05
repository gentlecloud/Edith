<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMultipleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newly_multiples', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('平台名称');
            $table->string('logo')->comment('平台LOGO')->nullable();
            $table->boolean('status')->default(1)->comment('状态');
            $table->string('remark')->nullable()->comment('备注');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('newly_multiple_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('store_id')->comment('关联平台ID');
            $table->bigInteger('admin_id')->comment('关联管理员ID');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['store_id','admin_id']);
        });

        Schema::create('newly_multiple_alis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('store_id')->unique()->comment('关联平台ID');
            $table->string('mini_name')->nullable()->comment('小程序名称');
            $table->string('mini_app_id')->nullable()->comment('小程序APPID');
            $table->string('mini_secret')->nullable()->comment('小程序SECRET');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('newly_multiple_wechats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('store_id')->comment('关联平台ID');
            $table->string('official_name')->nullable()->comment('公众号名称');
            $table->string('official_app_id')->nullable()->comment('公众号APPID');
            $table->string('official_secret')->nullable()->comment('公众号SECRET');
            $table->string('official_email')->nullable()->comment('公众号Email');
            $table->string('official_gh_id')->nullable()->comment('公众号原始ID');
            $table->string('official_token')->nullable()->comment('公众号Token');
            $table->string('official_aes_key')->nullable()->comment('公众号AES_KEY');
            $table->string('official_oauth_url')->nullable()->comment('公众号统一回调');
            $table->string('mini_name')->nullable()->comment('小程序名称');
            $table->string('mini_app_id')->nullable()->comment('小程序APPID');
            $table->string('mini_secret')->nullable()->comment('小程序SECRET');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['store_id']);
        });
        Schema::create('newly_multiple_platforms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('store_id')->unique()->comment('关联平台ID');
            $table->string('app_id')->nullable()->comment('开放平台APPID');
            $table->string('secret')->nullable()->comment('开放平台SECRET');
            $table->string('token')->nullable()->comment('开放平台TOKEN');
            $table->string('aes_key')->nullable()->comment('开放平台AES_KEY');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('newly_modules', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('模块名称');
            $table->string('name')->index()->comment('模块标识');
            $table->string('description')->nullable()->comment('模块简介');
            $table->string('author')->nullable()->comment('模块开发者');
            $table->string('website')->nullable()->comment('模块开发官网');
            $table->boolean('status')->default(1)->comment('模块状态0 待安装 1已安装 2已卸载');
            $table->string('mode')->default('local')->comment('模块运行模式 Local 本地模块 Cloud 云服务模块');
            $table->string('version')->default('v1.0.0')->comment('模块版本');
            $table->dateTime('expired_at')->nullable()->comment('模块到期时间');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('newly_module_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pid')->default(0)->index()->comment('上级分类ID');
            $table->string('name')->comment('分类名称');
            $table->string('description')->nullable()->comment('分类描述');
            $table->string('cover')->nullable()->comment('分类封面图');
            $table->double('page_num')->default(20)->comment('分类前端单页显示数量');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newly_multiples');
        Schema::dropIfExists('newly_multiple_users');
        Schema::dropIfExists('newly_multiple_alis');
        Schema::dropIfExists('newly_multiple_wechats');
        Schema::dropIfExists('newly_multiple_platforms');
        Schema::dropIfExists('newly_modules');
    }
}
