<?php

namespace Edith\Admin\Models\Seeders;

use Edith\Admin\Models\EdithConfig;
use Edith\Admin\Models\EdithMenu;
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
            ['title' => '网站名称', 'type' => 'text', 'name' => 'WEB_SITE_NAME', 'group_name' => '基本', 'value' => '翼搭（Edith）', 'remark' => ''],
            ['title' => '关键字', 'type' => 'text', 'name' => 'WEB_SITE_KEYWORDS', 'group_name' => '基本', 'value' => '翼搭（Edith）', 'remark' => ''],
            ['title' => '描述', 'type' => 'textarea', 'name' => 'WEB_SITE_DESCRIPTION', 'group_name' => '基本', 'value' => '翼搭（Edith）', 'remark' => ''],
            ['title' => 'Logo', 'type' => 'picture', 'name' => 'WEB_SITE_LOGO', 'group_name' => '基本', 'value' => '', 'remark' => ''],
            ['title' => '统计代码', 'type' => 'textarea', 'name' => 'WEB_SITE_SCRIPT', 'group_name' => '基本', 'value' => '', 'remark' => ''],
            ['title' => '网站版权', 'type' => 'text', 'name' => 'WEB_SITE_COPYRIGHT', 'group_name' => '基本', 'value' => '© 翼搭 Company 2022', 'remark' => ''],
            ['title' => '开启SSL', 'type' => 'switch', 'name' => 'SSL_OPEN', 'group_name' => '基本', 'value' => '0', 'remark' => ''],
            ['title' => '开启网站', 'type' => 'switch', 'name' => 'WEB_SITE_OPEN', 'group_name' => '基本', 'value' => '1', 'remark' => ''],
            ['title' => '单点登录', 'type' => 'switch', 'name' => 'WEB_LOGIN_SSO', 'group_name' => '基本', 'value' => '1', 'remark' => ''],
            ['title' => '登录验证码', 'type' => 'switch', 'name' => 'LOGIN_CAPTCHA', 'group_name' => '基本', 'value' => '1', 'remark' => ''],
            ['title' => '登录有效期', 'type' => 'digit', 'name' => 'LOGIN_VALID_TIME', 'group_name' => '基本', 'value' => '12', 'remark' => ''],
            ['title' => '调试模式', 'type' => 'switch', 'name' => 'APP_DEBUG', 'group_name' => '基本', 'value' => '0', 'remark' => ''],
            ['title' => '开发模式', 'type' => 'switch', 'name' => 'EDITH_DEV', 'group_name' => '基本', 'value' => '0', 'remark' => '']
        ]);

        // 菜单
        EdithMenu::insert([
            ['name' => '控制台', 'guard_name' => 'basic', 'icon' => 'icon-kongzhitaishouye', 'type' => 'default', 'parent_id' => 0, 'sort' => 0, 'path' => '/dashboard', 'is_dev' => 0],
            ['name' => '主页', 'guard_name' => 'basic', 'icon' => 'icon-shouye', 'type' => 'engine', 'parent_id' => 1, 'sort' => 0, 'path' => 'index', 'component' => 'Engine', 'is_dev' => 0],

            ['name' => '管理员', 'guard_name' => 'admin', 'icon' => 'icon-guanliyuan', 'type' => 'default', 'parent_id' => 0, 'sort' => 2, 'path' => '/auth', 'is_dev' => 0],
            ['name' => '管理员列表', 'guard_name' => 'admin', 'icon' => 'icon-guanliyuan2', 'type' => 'engine', 'parent_id' => 3, 'sort' => 0, 'path' => 'admin', 'component' => 'Engine', 'is_dev' => 0],
            ['name' => '菜单列表', 'guard_name' => 'admin', 'icon' => 'icon-caidan', 'type' => 'engine', 'parent_id' => 3, 'sort' => 0, 'path' => 'menu', 'component' => 'Engine', 'is_dev' => 0],
            ['name' => '权限列表', 'guard_name' => 'admin', 'icon' => 'icon-quanxian', 'type' => 'engine', 'parent_id' => 3, 'sort' => 0, 'path' => 'permission', 'component' => 'Engine', 'is_dev' => 0],
            ['name' => '角色列表', 'guard_name' => 'admin', 'icon' => 'icon-jiaoseguanli', 'type' => 'engine', 'parent_id' => 3, 'sort' => 0, 'path' => 'role', 'component' => 'Engine', 'is_dev' => 0],

            ['name' => '系统配置', 'guard_name' => 'admin', 'icon' => 'icon-setting', 'type' => 'default', 'parent_id' => 0, 'sort' => 4, 'path' => '/system', 'is_dev' => 0],
            ['name' => '网站设置', 'guard_name' => 'admin', 'icon' => 'icon-shezhi', 'type' => 'engine', 'parent_id' => 8, 'sort' => 0, 'path' => 'website', 'component' => 'Engine', 'is_dev' => 0],
            ['name' => '配置管理', 'guard_name' => 'admin', 'icon' => 'icon-peizhi', 'type' => 'engine', 'parent_id' => 8, 'sort' => 0, 'path' => 'config', 'component' => 'Engine', 'is_dev' => 1],
            ['name' => '操作日志', 'guard_name' => 'admin', 'icon' => 'icon-rizhi', 'type' => 'engine', 'parent_id' => 8, 'sort' => 0, 'path' => 'log', 'component' => 'Engine', 'is_dev' => 0],

            ['name' => '附件空间', 'guard_name' => 'basic', 'icon' => 'icon-fujian', 'type' => 'default', 'parent_id' => 0, 'sort' => 8, 'path' => '/attachments', 'is_dev' => 0],
            ['name' => '附件管理', 'guard_name' => 'basic', 'icon' => 'icon-icon-', 'type' => 'engine', 'parent_id' => 12, 'sort' => 0, 'path' => 'list', 'component' => 'Engine', 'is_dev' => 0],

            ['name' => '管理设置', 'guard_name' => 'basic', 'icon' => 'icon-zhanghao', 'type' => 'default', 'parent_id' => 0, 'sort' => 10, 'path' => '/account', 'is_dev' => 0],
            ['name' => '账号设置', 'guard_name' => 'basic', 'icon' => 'icon-profilesetting', 'type' => 'engine', 'parent_id' => 14, 'sort' => 0, 'path' => 'settings', 'component' => 'Engine', 'is_dev' => 0],
        ]);
    }
}
