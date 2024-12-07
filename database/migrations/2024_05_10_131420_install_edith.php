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
        Schema::create('edith_configs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('配置标题');
            $table->string('type')->comment('配置类型');
            $table->string('name', 64)->comment('配置名称')->unique();
            $table->string('group_name')->comment('分组名称');
            $table->longText('value')->nullable()->comment('配置值');
            $table->longText('remark')->nullable()->comment('备注');
            $table->timestamps();
        });

        Schema::create('edith_admins', function (Blueprint $table) {
            $table->id();
            $table->string('username', 64)->unique()->comment('账号');
            $table->string('nickname')->comment('昵称');
            $table->string('email')->index()->comment('邮箱')->nullable();
            $table->string('phone')->index()->comment('手机')->nullable();
            $table->string('password')->comment('密码');
            $table->string('avatar')->nullable()->comment('头像');
            $table->boolean('google_open')->default(0)->comment('GOOGLE验证器');
            $table->string('google_secret', 64)->nullable()->comment('GOOGLE SECRET');
            $table->timestamp('lasted_at')->nullable()->comment('最后登录时间');
            $table->boolean('status')->default(1)->comment('状态1启用');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('edith_auth_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('type', 64)->default('ADMIN')->comment('Token类型');
            $table->bigInteger('uid')->comment('关联用户ID');
            $table->longText('token')->comment('Token');
            $table->integer('expires')->comment('有效期');
            $table->timestamps();
            $table->index(['type', 'uid']);
        });

        Schema::create('edith_admin_logins', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('admin_id')->comment('管理员ID');
            $table->string('province')->nullable()->comment('登录省份');
            $table->string('city')->nullable()->comment('登录城市');
            $table->text('ip_info')->comment('IP信息')->nullable();
            $table->string('lasted_ip')->comment('登录IP');
            $table->timestamps();
            $table->index(['admin_id']);
        });

        Schema::create('edith_action_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('obj_id')->nullable()->comment('操作人');
            $table->string('url')->comment('操作URL');
            $table->string('method')->nullable()->comment('操作方式');
            $table->longText('content')->comment('操作内容')->nullable();
            $table->longText('remark')->comment('备注');
            $table->string('ip')->comment('IP');
            $table->string('region')->nullable()->comment('地区');
            $table->string('type')->comment('类型');
            $table->timestamps();
        });

        Schema::create('edith_attachment_categories', function (Blueprint $table) {
            $table->id();
            $table->string('obj_type')->default('ADMIN')->comment('分类归属角色的类型（ADMIN/PLATFORM）');
            $table->integer('obj_id')->default(0)->comment('分类归属角色id');
            $table->string('title')->comment('分类名称');
            $table->integer('sort')->default(0)->comment('排序');
            $table->string('description')->nullable()->comment('分类描述');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        /**
         * 附件资源
         */
        Schema::create('edith_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('obj_type')->default('ADMIN')->comment('附件归属角色的类型（ADMIN/PLATFORM）');
            $table->integer('obj_id')->default(0)->nullable()->comment('附件归属角色id');
            $table->integer('category_id')->default(0)->nullable()->comment('类目id');
            $table->string('name')->comment('名称');
            $table->string('size')->comment('大小');
            $table->integer('width')->default(0)->nullable()->comment('图片宽度');
            $table->integer('height')->default(0)->nullable()->comment('图片高度');
            $table->string('ext')->nullable()->comment('文件扩展名');
            $table->string('mime')->nullable()->comment('文件扩展名');
            $table->text('path')->comment('路径');
            $table->longText('md5')->comment('md5唯一标识');
            $table->string('driver')->comment('上传驱动')->default('local');
            $table->string('upload_ip')->comment('上传者IP');
            $table->timestamps();
        });

        Schema::create('edith_menus', function (Blueprint $table) {
            $table->id();
            $table->string('guard_name', 64)->comment('菜单组')->default('basic');
            $table->string('name', 64)->comment('菜单名称');
            $table->string('icon')->nullable()->comment('菜单图标');
            $table->string('target')->default('default')->comment('default:内置routers,engine:引擎页,blank:外链');
            $table->boolean('layout')->default(1)->comment('是否嵌套Layout');
            $table->integer('parent_id')->default(0)->comment('上级菜单ID');
            $table->integer('sort')->default(0)->comment('排序');
            $table->string('path')->nullable()->comment('路径')->unique();
            $table->string('module')->default('default')->comment('default:控制台/模块,system:控制台菜单,其他模块名称');
            $table->boolean('status')->default(1)->comment('状态');
            $table->boolean('is_dev')->default(0)->comment('开发菜单');
            $table->unique(['guard_name', 'name']);
            $table->timestamps();
        });

        Schema::create('edith_role_users', function (Blueprint $table) {
            $table->bigInteger('role_id');
            $table->bigInteger('user_id');
            $table->unique(['role_id', 'user_id']);
            $table->timestamps();
        });

        Schema::create('edith_roles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('platform_id')->default(0)->index();
            $table->string('name')->comment('权限名称');
            $table->string('guard_name')->comment('权限组')->index();
            $table->timestamps();
        });

        Schema::create('edith_permissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('platform_id')->default(0)->comment('关联平台ID');
            $table->bigInteger('menu_id')->default(0)->comment('关联菜单ID');
            $table->string('name', 64)->comment('权限名称');
            $table->string('uri', 200)->comment('权限URI')->unique();
            $table->timestamps();
        });

        Schema::create('edith_role_permissions', function (Blueprint $table) {
            $table->bigInteger('role_id');
            $table->bigInteger('permission_id');
            $table->unique(['role_id', 'permission_id']);
            $table->timestamps();
        });

        Schema::create('edith_role_menus', function (Blueprint $table) {
            $table->bigInteger('role_id');
            $table->bigInteger('menu_id');
            $table->unique(['role_id', 'menu_id']);
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
        Schema::dropIfExists('edith_configs');
        Schema::dropIfExists('edith_admins');
        Schema::dropIfExists('edith_auth_tokens');
        Schema::dropIfExists('edith_action_logs');
        Schema::dropIfExists('edith_attachment_categories');
        Schema::dropIfExists('edith_attachments');
        Schema::dropIfExists('edith_menus');
        Schema::dropIfExists('edith_role_users');
        Schema::dropIfExists('edith_roles');
        Schema::dropIfExists('edith_permissions');
        Schema::dropIfExists('edith_role_permissions');
        Schema::dropIfExists('edith_role_menus');
    }

    /**
     * 填充初始数据
     * @return void
     */
    public function fillInitialData()
    {

    }
};