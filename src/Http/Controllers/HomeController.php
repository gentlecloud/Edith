<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Components\Actions\Action;
use Edith\Admin\Components\Columns\Column;
use Edith\Admin\Components\Displays\Avatar;
use Edith\Admin\Components\Displays\Iconfont;
use Edith\Admin\Components\Displays\Image;
use Edith\Admin\Components\Displays\Link;
use Edith\Admin\Components\Displays\Statistic;
use Edith\Admin\Components\Displays\Text;
use Edith\Admin\Components\Displays\Title;
use Edith\Admin\Components\Displays\Tpl;
use Edith\Admin\Components\Fields\DescriptionsItem;
use Edith\Admin\Components\Fields\Field;
use Edith\Admin\Components\Layouts\Col;
use Edith\Admin\Components\Layouts\Flex;
use Edith\Admin\Components\Layouts\Row;
use Edith\Admin\Components\Layouts\Space;
use Edith\Admin\Components\Layouts\WaterMark;
use Edith\Admin\Components\Pages\Descriptions;
use Edith\Admin\Components\Pages\PageContainer;
use Edith\Admin\Components\Pages\ProCard;
use Edith\Admin\Components\Pages\StatisticCard;
use Edith\Admin\Components\Pages\StatisticCardGroup;
use Edith\Admin\Components\Pages\Wrapper;
use Edith\Admin\Exceptions\RendererException;
use Edith\Admin\Facades\EdithAdmin;
use Edith\Admin\Models\EdithActionLog;
use Edith\Admin\Models\EdithAdmin as EdithAdminModel;
use Edith\Admin\Models\EdithAdminLogin;
use Edith\Admin\Models\EdithAttachment;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * 仪表盘
     * @return \Illuminate\Http\JsonResponse
     * @throws RendererException
     */
    public function dashboard()
    {
        $user = \auth('manage')->user();
        $avatar = json_decode($user['avatar'], true);
        $body = [
            (new Row())->gutter(20)->body(
                (new Col())->span(24)->body([
                    (new ProCard())->body([
                        (new Flex())->align('center')->gap('middle')->body([
                            (new Avatar($avatar['url'] ?? $user['avatar']))->size(75),
                            (new Wrapper())->body([
                                (new Text($this->getGreeting() . '！' . $user->nickname))->strong()->style(['fontSize' => '20px', 'marginBottom' => '5px']),
                                (new Text('有翼 · 即搭，赋能高效构建便捷的新引擎，无需重复造轮子！'))->style(['fontSize' => '14px']),
                            ])->style(['flex' => 1, 'display' => 'flex', 'flexDirection' => 'column']),
                            (new Wrapper())->body([
                                (new Text())->id('clock')->strong()->style(['textAlign' => 'center', 'color' => '#fff', 'fontSize' => '26px']),
                                (new Text())->id('clock-date')->style(['textAlign' => 'center', 'color' => '#fff', 'fontSize' => '16px']),
                                (new Tpl())
                                    ->onMount(<<<JS
        const clock = document.getElementById('clock');
        const tick = () => {
            clock.innerHTML = (new Date()).toLocaleTimeString();
            requestAnimationFrame(tick);
        };
        tick();
        
        const clockDate = document.getElementById('clock-date');
        clockDate.innerHTML = (new Date()).toLocaleDateString('zh-CN', {year: 'numeric',month: 'long',day: 'numeric'});
        JS
                                    )
                            ])->style(['width' => '160px', 'backgroundColor' => '#1677ff', 'display' => 'flex', 'flexDirection' => 'column', 'align' => 'center', 'justifyContent' => 'center', 'padding' => '10px 0', 'borderRadius' => '5px'])
                        ]),
                    ]),
                ]),
            ),
            (new StatisticCardGroup())->body([
                (new StatisticCard())->statistic((new Statistic())->title('管理员数量')->icon((new Iconfont('icon-guanliyuan3'))->style(['fontSize' => '42px']))->value(EdithAdminModel::count())),
                (new StatisticCard())->statistic((new Statistic())->title('附件数量')->icon((new Iconfont('icon-fujian1'))->style(['fontSize' => '44px']))->value(EdithAttachment::count())),
                (new StatisticCard())->statistic(function (Statistic $statistic) {
                    $statistic->title('登录次数')->value(EdithAdminLogin::count())->icon((new Iconfont('icon-xiazaifujian'))->style(['fontSize' => '42px']));
                }),
                (new StatisticCard())->statistic(function (Statistic $statistic) {
                    $statistic->title('操作次数')->icon((new Iconfont('icon-tubiao-33'))->style(['fontSize' => '44px']))->value(EdithActionLog::count());
                }),
            ]),
            (new Row())->gutter(20)->body(
                [
                    (new Col())->body([
                        (new ProCard())->body(
                            (new Flex)->body([
                                (new Image('https://newly.oss-cn-shanghai.aliyuncs.com/images/GENTLE_LOGO.jpeg'))->width(110)->height(110)->preview(false),
                                (new Title())->text(config('edith.name', '翼搭（Edith）'))->level(3)->style(['marginBottom' => '17.15px']),
                                (new Space())->body([
                                    (new Link())->text('Github')->href('https://github.com/gentlecloud/Edith')->target('_blank')->icon('icon-github')->style(['fontSize' => '15px']),
                                    (new Link())->text('湛拓科技')->className('mx-5')->href('https://www.gentle.org.cn')->target('_blank')->style(['fontSize' => '15px']),
                                    (new Link())->text('翼搭官网')->className('mx-5')->href('https://www.ieda.cc')->target('_blank')->style(['fontSize' => '15px']),
                                ])->size(30)
                            ])->vertical()->justify('center')->align('center')
                        ),
                    ])->span(10),
                    (new Col())->span(7)->body((new ProCard())->body($this->systemInfo())),
                    (new Col())->span(7)->body(

                    ),
                ]
            )
        ];
        return engine((new WaterMark(edith_config('WEB_SITE_NAME', 'Edith Admin')))->body((new PageContainer)->title('仪表盘')->subTitle('首页')->extra(
            (new Action('刷新'))->actionType('refresh')
        )->content($body)), false);
    }

    /**
     * @return
     */
    protected function systemInfo()
    {
        if (str_contains(PHP_OS, "Linux")) {
            $os = "linux";
        } else if (str_contains(PHP_OS, "WIN")) {
            $os = "windows";
        } else {
            $os = PHP_OS;
        }

        $mySql = DB::connection()->getPdo()->getAttribute(\PDO::ATTR_SERVER_VERSION);

        $items = [
            (new DescriptionsItem('系统名称'))->value(edith_config('WEB_SITE_NAME', 'Edith Admin')),
            (new DescriptionsItem('Edith版本'))->value(EdithAdmin::version()),
            (new DescriptionsItem('框架版本'))->value("Laravel " . app()::VERSION),
            (new DescriptionsItem('运行环境'))->value($os . ' ' . substr($_SERVER['SERVER_SOFTWARE'],0,50) . ' mysql/' . $mySql),
            (new DescriptionsItem)->label('上传限制')->value(ini_get('upload_max_filesize')),
        ];

        return (new Descriptions())->title('系统信息')->column(1)->items($items);
    }

    /**
     * @return string
     */
    protected function getGreeting(): string
    {
        $hour = (int) date('H');

        if ($hour >= 5 && $hour < 11) {
            return '早上好';
        } elseif ($hour >= 11 && $hour < 13) {
            return '中午好';
        } elseif ($hour >= 13 && $hour < 18) {
            return '下午好';
        } elseif ($hour >= 18 && $hour < 22) {
            return '晚上好';
        } else {
            return '凌晨好';
        }
    }
}