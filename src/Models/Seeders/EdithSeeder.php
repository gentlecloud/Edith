<?php

namespace Gentle\Edith\Models\Seeders;

use Gentle\Edith\Models\EdithConfig;
use Gentle\Edith\Models\EdithMenu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EdithSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 网站配置
        EdithConfig::insert([
            ['title' => '网站名称','type' => 'text','name' => 'WEB_SITE_NAME','group_name' => '基本','value' => '翼搭（Edith）','remark' => ''],
            ['title' => '关键字','type' => 'text','name' => 'WEB_SITE_KEYWORDS','group_name' => '基本','value' => '翼搭（Edith）','remark' => ''],
            ['title' => '描述','type' => 'textarea','name' => 'WEB_SITE_DESCRIPTION','group_name' => '基本','value' => '翼搭（Edith）','remark' => ''],
            ['title' => 'Logo','type' => 'picture','name' => 'WEB_SITE_LOGO','group_name' => '基本','value' => '','remark' => ''],
            ['title' => '统计代码','type' => 'textarea','name' => 'WEB_SITE_SCRIPT','group_name' => '基本','value' => '','remark' => ''],
            ['title' => '网站版权','type' => 'text','name' => 'WEB_SITE_COPYRIGHT','group_name' => '基本','value' => '© 翼搭 Company 2022','remark' => ''],
            ['title' => '开启SSL','type' => 'switch','name' => 'SSL_OPEN','group_name' => '基本','value' => '0','remark' => ''],
            ['title' => '开启网站','type' => 'switch','name' => 'WEB_SITE_OPEN','group_name' => '基本','value' => '1','remark' => ''],
            ['title' => '登录验证码','type' => 'switch','name' => 'LOGIN_CAPTCHA','group_name' => '基本','value' => '1','remark' => ''],
            ['title' => '开发者模式','type' => 'switch','name' => 'APP_DEBUG','group_name' => '基本','value' => '0','remark' => ''],
        ]);

        // 菜单
        EdithMenu::insert([
            ['name' => '控制台','guard_name' => 'admin','icon' => 'icon-kongzhitaishouye','type'=>'default','pid' => 0,'sort' => -2,'path' => '/dashboard','module'=>'default','status' => 1],
            ['name' => '主页','guard_name' => 'admin','icon' => 'icon-shouye','type'=>'engine','pid' => 1,'sort' => 0,'path' => 'manage/dashboard/index','module'=>'default','status' => 1],

            ['name' => '管理员','guard_name' => 'admin','icon' => 'icon-guanliyuan','type'=>'default','pid' => 0,'sort' => 0,'path' => '/auth','module'=>'system','status' => 1],
            ['name' => '管理员列表','guard_name' => 'admin','icon' => 'icon-guanliyuan2','type'=>'engine','pid' => 3,'sort' => 0,'path' => 'manage/manage/index','module'=>'system','status' => 1],
            ['name' => '菜单列表','guard_name' => 'admin','icon' => 'icon-caidan','type'=>'engine','pid' => 3,'sort' => 0,'path' => 'manage/menu/index','module'=>'system','status' => 1],
            ['name' => '权限列表','guard_name' => 'admin','icon' => 'icon-quanxian','type'=>'engine','pid' => 3,'sort' => 0,'path' => 'manage/permission/index','module'=>'system','status' => 1],
            ['name' => '角色列表','guard_name' => 'admin','icon' => 'icon-jiaoseguanli','type'=>'engine','pid' => 3,'sort' => 0,'path' => 'manage/role/index','module'=>'system','status' => 1],

            ['name' => '系统配置','guard_name' => 'admin','icon' => 'icon-setting','type'=>'default','pid' => 0,'sort' => 0,'path' => '/system','module'=>'system','status' => 1],
            ['name' => '网站设置','guard_name' => 'admin','icon' => 'icon-shezhi','type'=>'engine','pid' => 8,'sort' => 0,'path' => 'manage/config/website','module'=>'system','status' => 1],
            ['name' => '布局设置','guard_name' => 'admin','icon' => 'icon-buju','type'=>'engine','pid' => 8,'sort' => 0,'path' => 'manage/layout/config','module'=>'system','status' => 1],
            ['name' => '配置管理','guard_name' => 'admin','icon' => 'icon-peizhi','type'=>'engine','pid' => 8,'sort' => 0,'path' => 'manage/config/index','module'=>'system','status' => 1],
            ['name' => '操作日志','guard_name' => 'admin','icon' => 'icon-rizhi','type'=>'engine','pid' => 8,'sort' => 0,'path' => 'manage/actionLog/index','module'=>'system','status' => 1],

            ['name' => '应用模块','guard_name' => 'admin','icon' => 'icon-yingyong4','type'=>'default','pid' => 0,'sort' => 0,'path' => '/modules','module'=>'system','status' => 1],
            ['name' => '模块列表','guard_name' => 'admin','icon' => 'icon-yingyong3','pid' => 13,'type'=>'engine','sort' => 0,'path' => 'manage/modules/index','module'=>'system','status' => 1],

            ['name' => '平台管理','guard_name' => 'admin','icon' => 'icon-yingyong5','type'=>'default','pid' => 0,'sort' => 0,'path' => '/multiple','module'=>'system','status' => 1],
            ['name' => '平台列表','guard_name' => 'admin','icon' => 'icon-yingyong2','pid' => 15,'type'=>'engine','sort' => 0,'path' => 'manage/multiple/index','module'=>'system','status' => 1],

            ['name' => '财务管理','guard_name' => 'admin','icon' => 'icon-fujian','type'=>'default','pid' => 0,'sort' => 0,'path' => '/records','module'=>'system','status' => 1],
            ['name' => '财务明细','guard_name' => 'admin','icon' => 'icon-icon-','pid' => 17,'type'=>'engine','sort' => 0,'path' => 'manage/records/index','module'=>'system','status' => 1],
            ['name' => '支付通道','guard_name' => 'admin','icon' => 'icon-tupian','pid' => 17,'type'=>'engine','sort' => 0,'path' => 'manage/payment/index','module'=>'system','status' => 1],
            ['name' => '支付订单','guard_name' => 'admin','icon' => 'icon-tupian','pid' => 17,'type'=>'engine','sort' => 0,'path' => 'manage/records/pay','module'=>'system','status' => 1],

            ['name' => '附件空间','guard_name' => 'admin','icon' => 'icon-fujian','type'=>'default','pid' => 0,'sort' => 0,'path' => '/attachment','module'=>'default','status' => 1],
            ['name' => '附件管理','guard_name' => 'admin','icon' => 'icon-icon-','pid' => 21,'type'=>'engine','sort' => 0,'path' => 'manage/attachment/index','module'=>'default','status' => 1],

            ['name' => '我的账号','guard_name' => 'admin','icon' => 'icon-zhanghao','type'=>'default','pid' => 0,'sort' => 0,'path' => '/account','module'=>'default','status' => 1],
            ['name' => '个人设置','guard_name' => 'admin','icon' => 'icon-profilesetting','type'=>'default','pid' => 23,'sort' => 0,'path' => '/account/settings','module'=>'default','status' => 1],
        ]);
    }
}
