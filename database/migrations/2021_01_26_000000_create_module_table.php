<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edith_module_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('store_id')->comment('关联平台ID');
            $table->string('member_id',64)->comment('关联会员信息ID');
            $table->bigInteger('third_id')->comment('关联三方索引');
            $table->string('user_name',64)->comment('用户名');
            $table->string('password')->comment('密码');
            $table->string('salt')->comment('干扰值');
            $table->string('pay_password')->nullable()->comment('支付密码');
            $table->string('nick_name')->nullable()->comment('昵称');
            $table->string('avatar')->nullable()->comment('头像');
            $table->string('tel',50)->nullable()->comment('联系方式');
            $table->string('email',50)->nullable()->comment('Email');
            $table->bigInteger('lev1_leader')->nullable()->index()->comment('直接邀请人');
            $table->bigInteger('lev2_leader')->nullable()->index()->comment('间接邀请人');
            $table->bigInteger('lev3_leader')->nullable()->index()->comment('末级邀请人');
            $table->string('last_ip')->nullable()->comment('最后登录IP');
            $table->dateTime('lasted_at')->nullable()->comment('最后登录时间');
            $table->boolean('status')->default(1)->comment('状态 1启用 2禁用');
            $table->string('invite_code',64)->unique()->comment('邀请码');
            $table->string('remember_token')->nullable();
            $table->string('module',64)->index()->comment('来源模块');
            $table->boolean('is_oauth')->default(0)->comment('是否三方oAuth授权用户');
            $table->string('remark')->nullable()->comment('备注');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['store_id','user_name']);
            $table->unique(['third_id','member_id']);
        });

        Schema::create('edith_module_members', function (Blueprint $table) {
            $table->string('id',64)->unique()->comment('会员ID');
            $table->bigInteger('level_id')->default(0)->index()->comment('关联会员等级 0默认会员组');
            $table->string('real_name')->nullable()->comment('真实姓名');
            $table->tinyInteger('sex')->default(0)->comment('性别0未知 1男 2女');
            $table->string('card')->nullable()->comment('证件号码');
            $table->date('birthday')->nullable()->comment('生日');
            $table->string('bank_no')->nullable()->comment('关联银行卡');
            $table->string('bank_type',64)->default('alipay')->index()->comment('关联银行类型 alipay支付宝 bank银行卡 wechat微信等');
            $table->string('bank_name')->nullable()->comment('银行名称');
            $table->decimal('money')->default(0)->unsigned()->comment('会员余额');
            $table->decimal('frozen_money')->default(0)->unsigned()->comment('冻结金额');
            $table->decimal('sum_money')->default(0)->unsigned()->comment('总收入');
            $table->decimal('point')->default(0)->unsigned()->comment('会员积分');
            $table->double('purchases_count')->default(0)->unsigned()->comment('消费次数');
            $table->decimal('purchases_money')->default(0)->unsigned()->comment('消费金额');
            $table->string('qq')->nullable()->comment('QQ');
            $table->longText('wechat')->nullable()->comment('微信信息');
            $table->longText('wechat_work')->nullable()->comment('企业微信信息');
            $table->string('country')->nullable()->comment('国家');
            $table->string('province')->nullable()->comment('省份');
            $table->string('city')->nullable()->comment('城市');
            $table->string('district')->nullable()->comment('城区');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('edith_module_levels', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('store_id')->index()->comment('关联平台ID');
            $table->string('name')->comment('等级名称');
            $table->mediumText('describe')->nullable()->comment('等级描述');
            $table->decimal('upgrade_price')->nullable()->comment('升级价格');
            $table->boolean('status')->default(1)->comment('状态');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('edith_module_signeds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('store_id')->comment('关联平台ID');
            $table->string('member_id',64)->comment('关联会员ID');
            $table->double('day')->default(1)->comment('签到天数');
            $table->timestamps();

            $table->unique(['store_id','member_id']);
        });

        Schema::create('newly_module_signed_logs', function (Blueprint $table) {
            $table->id();
            $table->string('member_id',64)->comment('关联会员ID');
            $table->double('number')->default(1)->comment('签到次数');
            $table->timestamps();

            $table->unique(['member_id','number']);
        });

        Schema::create('newly_module_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('member_id',64)->unique()->comment('关联会员ID');
            $table->string('name')->comment('姓名');
            $table->string('phone')->comment('电话');
            $table->string('postal_code')->nullable()->comment('邮编');
            $table->string('country')->default('中国')->comment('国家');
            $table->string('province')->nullable()->comment('省份');
            $table->string('city')->nullable()->comment('城市');
            $table->string('district')->nullable()->comment('城区');
            $table->mediumText('address')->nullable()->comment('详细地址');
            $table->string('longitude')->nullable()->comment('经度');
            $table->string('latitude')->nullable()->comment('纬度');
            $table->boolean('is_default')->default(0)->comment('是否默认地址');
            $table->timestamps();
        });

        Schema::create('newly_module_points', function (Blueprint $table) {
            $table->id();
            $table->string('member_id',64)->unique()->comment('关联会员ID');
            $table->decimal('before')->default(0)->unsigned()->comment('变动前积分');
            $table->decimal('point')->default(0)->unsigned()->comment('变动积分');
            $table->decimal('after')->default(0)->unsigned()->comment('变动后积分');
            $table->string('type')->default('+')->comment('变动类型');
            $table->string('origin')->nullable()->comment('积分来源');
            $table->string('remark')->nullable()->comment('备注');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('newly_third_users', function (Blueprint $table) {
            $table->id();
            $table->string('appid',64)->index()->comment('三方APPID');
            $table->string('unionid',64)->nullable()->unique()->comment('三方联盟ID');
            $table->string('openid',64)->comment('三方OPENID');
            $table->string('nick_name')->nullable()->comment('三方用户昵称');
            $table->string('head_img_url')->nullable()->comment('用户头像');
            $table->tinyInteger('sex')->default(0)->comment('用户性别');
            $table->string('country')->nullable()->comment('国家');
            $table->string('province')->nullable()->comment('省份');
            $table->string('city')->nullable()->comment('城市');
            $table->string('language')->default('zh_CN')->comment('用户语言，默认中文zh_CN');
            $table->mediumText('tags')->nullable()->comment('用户标签');
            $table->boolean('is_black')->default(0)->index()->unsigned()->comment('是否黑名单用户');
            $table->boolean('is_subscribe')->default(1)->index()->unsigned()->comment('是否关注');
            $table->string('spread_openid',64)->index()->comment('推荐人OPENID');
            $table->dateTime('spread_at')->nullable()->comment('推荐时间');

            $table->string('qr_scene')->nullable()->comment('二维码场景值');
            $table->string('qr_scene_str')->nullable()->comment('二维码场景内容');
            $table->dateTime('subscribed_at')->nullable()->comment('关注时间');
            $table->string('origin',64)->default('wechat')->index()->comment('三方信息来源 wechat:微信 alipay:支付宝等');
            $table->string('channel',64)->default('official')->index()->comment('三方信息类别 official：公众号 miniprogarm:小程序等');
            $table->string('remark')->nullable()->comment('备注');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['appid','openid']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newly_module_ysers');
        Schema::dropIfExists('newly_module_members');
        Schema::dropIfExists('newly_module_levels');
        Schema::dropIfExists('newly_module_signeds');
        Schema::dropIfExists('newly_module_signed_logs');
        Schema::dropIfExists('newly_module_addresses');
        Schema::dropIfExists('newly_module_points');
        Schema::dropIfExists('newly_third_users');
    }
}
