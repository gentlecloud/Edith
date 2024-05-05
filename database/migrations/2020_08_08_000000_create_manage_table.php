<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edith_configs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('配置标题');
            $table->string('type')->comment('配置类型');
            $table->string('name')->comment('配置名称');
            $table->string('group_name')->comment('分组名称');
            $table->longText('value')->nullable()->comment('配置值');
            $table->longText('remark')->nullable()->comment('备注');
            $table->timestamps();
        });

        Schema::create('newly_admins', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pid')->default(0)->index()->comment('上级ID');
            $table->string('username',64)->unique()->comment('账号');
            $table->string('nickname')->comment('昵称');
            $table->string('email')->index()->comment('邮箱')->nullable();
            $table->string('phone')->index()->comment('手机')->nullable();
            $table->tinyInteger('sex')->default(1)->comment('1男 2女');
            $table->string('password')->comment('密码');
            $table->string('avatar')->nullable()->comment('头像');
            $table->string('wechat_openid')->nullable()->comment('微信OPENID');
            $table->string('wechat_unionid')->nullable()->comment('微信UNIONID');
            $table->boolean('google_open')->default(0)->comment('GOOGLE验证器');
            $table->string('google_secret')->nullable()->comment('GOOGLE SECRET');
            $table->longText('provinces')->nullable()->comment('常登录省份');
            $table->string('lasted_ip')->nullable()->comment('最后登录IP');
            $table->timestamp('lasted_at')->nullable()->comment('最后登录时间');
            $table->boolean('status')->default(1)->comment('状态1启用');
            $table->string('api_token')->nullable()->comment('访问Token');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('newly_auth_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('type',64)->default('ADMIN')->comment('Token类型');
            $table->bigInteger('uid')->comment('关联用户ID');
            $table->longText('token')->comment('Token');
            $table->integer('expires')->comment('有效期');
            $table->timestamps();
            $table->unique(['type','uid']);
        });

        Schema::create('newly_action_logs', function (Blueprint $table) {
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

        Schema::create('newly_attachment_categories', function (Blueprint $table) {
            $table->id();
            $table->string('obj_type')->default('ADMINID')->comment('分类归属角色的类型（ADMINID/STOREID/MCHID等）');
            $table->integer('obj_id')->default(0)->comment('分类归属角色id');
            $table->string('title')->comment('分类名称');
            $table->integer('sort')->default(0)->comment('排序');
            $table->string('description')->nullable()->comment('分类描述');
            $table->boolean('status')->default(1);
        });

        /**
         * 附件资源
         */
        Schema::create('newly_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('obj_type')->default('ADMINID')->comment('附件归属角色的类型（ADMINID/STOREID/MCHID等）');
            $table->integer('obj_id')->default(0)->nullable()->comment('附件归属角色id');
            $table->integer('category_id')->default(0)->nullable()->comment('类目id');
            $table->string('name')->comment('名称');
            $table->string('size')->comment('大小');
            $table->integer('width')->default(0)->nullable()->comment('图片宽度');
            $table->integer('height')->default(0)->nullable()->comment('图片高度');
            $table->string('ext')->nullable()->comment('文件扩展名');
            $table->text('path')->comment('路径');
            $table->longText('md5')->comment('md5唯一标识');
            $table->string('driver')->comment('上传驱动')->default('local');
            $table->string('upload_ip')->comment('上传者IP');
            $table->timestamps();
        });

        Schema::create('newly_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('菜单名称');
            $table->string('guard_name')->comment('菜单组');
            $table->string('icon')->nullable()->comment('菜单图标');
            $table->string('type')->default('default')->comment('default:内置routers,engine:引擎页,blank:外链');
            $table->integer('pid')->default(0)->comment('上级菜单ID');
            $table->integer('sort')->default(0)->comment('排序');
            $table->string('path')->nullable()->comment('路径');
            $table->string('module')->default('default')->comment('default:控制台/模块,system:控制台菜单,其他模块名称');
            $table->boolean('status')->default(1)->comment('状态');
            $table->timestamps();
        });

        Schema::create('newly_role_users', function (Blueprint $table) {
            $table->bigInteger('role_id');
            $table->bigInteger('user_id');
            $table->index(['role_id', 'user_id']);
            $table->timestamps();
        });

        Schema::create('newly_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('权限名称');
            $table->string('guard_name')->comment('权限组');
            $table->timestamps();
        });

        Schema::create('newly_permissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('menu')->default(0)->comment('权限名称');
            $table->string('uri',64)->comment('权限URI');
            $table->mediumText('methods')->nullable()->comment('METHOD');
            $table->timestamps();
            $table->unique(['menu','uri']);
        });

        Schema::create('newly_role_permissions', function (Blueprint $table) {
            $table->bigInteger('role_id');
            $table->bigInteger('permission_id');
            $table->unique(['role_id', 'permission_id']);
            $table->timestamps();
        });

        Schema::create('newly_role_menus', function (Blueprint $table) {
            $table->bigInteger('role_id');
            $table->bigInteger('menu_id');
            $table->unique(['role_id', 'menu_id']);
            $table->timestamps();
        });

        Schema::create('newly_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('store_id')->default(0);
            $table->string('title')->comment('通道名称');
            $table->string('name',64)->nullable()->comment('显示名称');
            $table->string('code',64)->nullable()->comment('通道代码');
            $table->string('logo')->nullable()->comment('通道LOGO');
            $table->string('icon',64)->nullable()->comment('通道ICON 优先于LOGO');
            $table->string('channel')->comment('所属通道Alipay WechatPay UnionPay');
            $table->string('type',64)->default('all')->comment('支付类型all pc mobile miniprogram等');
            $table->string('mhc_id')->comment('商户号');
            $table->string('app_id')->nullable()->comment('通道APPID');
            $table->string('gateway')->nullable()->comment('支付网关 通常仅用于三方接口');
            $table->longText('public_key')->nullable()->comment('通道公钥');
            $table->longText('private_key')->nullable()->comment('通道私钥');
            $table->mediumText('public_cert_path')->nullable()->comment('应用证书');
            $table->mediumText('app_cert_path')->nullable()->comment('根证书');
            $table->mediumText('app_key_path')->nullable()->comment('私钥证书');
            $table->string('notify_url')->nullable()->comment('通道异步回调链接');
            $table->string('return_url')->nullable()->comment('通道同步回调链接');
            $table->boolean('is_available')->default(0)->comment('是否支持打款');
            $table->boolean('is_default')->default(0)->comment('是否默认通道');
            $table->boolean('is_recommend')->default(0)->comment('是否推荐通道');
            $table->boolean('status')->default(1)->comment('通道状态');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['store_id','code']);
        });

        Schema::create('newly_pays', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('store_id')->index()->comment('关联平台ID 0为主平台');
            $table->bigInteger('uid')->comment('关联用户ID');
            $table->string('sn',64)->comment('订单编号');
            $table->string('thirdparty_order_no',64)->nullable()->comment('三方订单编号');
            $table->string('title')->nullable()->comment('订单标题');
            $table->decimal('money')->default(0)->comment('订单金额');
            $table->decimal('refund_money')->nullable()->comment('退款金额');
            $table->mediumText('refund_sn')->nullable()->comment('退款单号');
            $table->mediumText('refund_thirdparty_sn')->nullable()->comment('三方退款单号');
            $table->string('openid')->nullable()->comment('用户OPENID');
            $table->bigInteger('pay_channel')->comment('支付通道索引ID')->index();
            $table->string('pay_code')->nullable()->comment('通道代码');
            $table->string('hook')->nullable()->comment('回调钩子');
            $table->mediumText('hook_params')->nullable()->comment('钩子参数');
            $table->integer('status')->default(1)->comment('订单状态1 待支付 2已支付 3退款 99关闭');
            $table->dateTime('paid_at')->nullable()->comment('支付时间');
            $table->string('modules', 64)->default('main')->comment('订单来源标识 main 主平台订单，模块请使用模块标识');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['uid','sn','thirdparty_order_no','modules']);
        });

        Schema::create('newly_records', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('store_id')->index()->comment('关联平台ID');
            $table->string('member_id')->index()->comment('关联会员ID');
            $table->decimal('money')->default(0)->unsigned()->comment('变动金额');
            $table->decimal('before_money')->nullable()->unsigned()->comment('变动前余额');
            $table->decimal('after_money')->nullable()->unsigned()->comment('变动后余额');
            $table->string('type',20)->default('+')->comment('变动类型');
            $table->string('origin')->nullable()->comment('资金来源');
            $table->string('operator')->default('system')->comment('操作人');
            $table->string('modules')->default('system')->comment('来源模块');
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
        Schema::dropIfExists('edith_configs');
        Schema::dropIfExists('newly_admins');
        Schema::dropIfExists('newly_auth_tokens');
        Schema::dropIfExists('newly_action_logs');
        Schema::dropIfExists('newly_attachment_categories');
        Schema::dropIfExists('newly_attachments');
        Schema::dropIfExists('newly_menus');
        Schema::dropIfExists('newly_role_users');
        Schema::dropIfExists('newly_roles');
        Schema::dropIfExists('newly_permissions');
        Schema::dropIfExists('newly_role_permissions');
        Schema::dropIfExists('newly_role_menus');
        Schema::dropIfExists('newly_payments');
        Schema::dropIfExists('newly_pays');
        Schema::dropIfExists('newly_records');
    }
}
