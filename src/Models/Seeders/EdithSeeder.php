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
            ['title' => '开发者模式', 'type' => 'switch', 'name' => 'EDITH_DEV', 'group_name' => '基本', 'value' => '0', 'remark' => '']
        ]);

        // 菜单
        EdithMenu::insert([
            ['name' => '控制台', 'guard_name' => 'basic', 'icon' => 'icon-kongzhitaishouye', 'target' => 'default', 'sort' => 0, 'path' => '/dashboard', 'module' => 'default'],
            ['name' => '主页', 'guard_name' => 'basic', 'icon' => 'icon-shouye', 'target' => 'engine', 'parent_id' => 1, 'path' => 'index', 'module' => 'default'],

            ['name' => '管理员', 'guard_name' => 'admin', 'icon' => 'icon-guanliyuan', 'target' => 'default', 'sort' => 2, 'path' => '/auth', 'module' => 'system'],
            ['name' => '管理员列表', 'guard_name' => 'admin', 'icon' => 'icon-guanliyuan2', 'target' => 'engine', 'parent_id' => 3, 'path' => 'admin', 'module' => 'system'],
            ['name' => '菜单列表', 'guard_name' => 'admin', 'icon' => 'icon-caidan', 'target' => 'engine', 'parent_id' => 3, 'path' => 'menu', 'module' => 'system'],
            ['name' => '权限列表', 'guard_name' => 'admin', 'icon' => 'icon-quanxian', 'target' => 'engine', 'parent_id' => 3, 'path' => 'permission', 'module' => 'system'],
            ['name' => '角色列表', 'guard_name' => 'admin', 'icon' => 'icon-jiaoseguanli', 'target' => 'engine', 'parent_id' => 3, 'path' => 'role', 'module' => 'system'],

            ['name' => '系统配置', 'guard_name' => 'admin', 'icon' => 'icon-setting', 'target' => 'default', 'sort' => 4, 'path' => '/system', 'module' => 'system'],
            ['name' => '网站设置', 'guard_name' => 'admin', 'icon' => 'icon-shezhi', 'target' => 'engine', 'parent_id' => 8, 'path' => 'website', 'module' => 'system'],
            ['name' => '配置管理', 'guard_name' => 'admin', 'icon' => 'icon-peizhi', 'target' => 'engine', 'parent_id' => 8, 'path' => 'config', 'module' => 'system', 'is_dev' => 1],
            ['name' => '操作日志', 'guard_name' => 'admin', 'icon' => 'icon-rizhi', 'target' => 'engine', 'parent_id' => 8, 'path' => 'actionLog/index', 'module' => 'system'],

            ['name' => '附件空间', 'guard_name' => 'basic', 'icon' => 'icon-fujian', 'type' => 'target', 'sort' => 8, 'path' => '/attachments', 'module' => 'default'],
            ['name' => '附件管理', 'guard_name' => 'basic', 'icon' => 'icon-icon-', 'parent_id' => 14, 'target' => 'engine', 'path' => 'list', 'module' => 'default'],

            ['name' => '管理设置', 'guard_name' => 'basic', 'icon' => 'icon-zhanghao', 'target' => 'default', 'sort' => 10, 'path' => '/account', 'module' => 'default'],
            ['name' => '账号设置', 'guard_name' => 'basic', 'icon' => 'icon-profilesetting', 'target' => 'default', 'parent_id' => 16, 'path' => 'settings', 'module' => 'default'],
        ]);
    }
}
