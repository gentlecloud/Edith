<?php
namespace Edith\Admin\Components\Tables;

use Edith\Admin\Components\Renderer;

/**
 * Table Toolbar
 * https://procomponents.ant.design/components/table#listtoolbarprops
 * @method $this title(string $title)                       标题
 * @method $this subTitle(string $subTitle)                 子标题
 * @method $this tooltip(string $tooltip)                   tooltip 描述
 * @method $this search(array $search)                      查询区
 * @method $this actions(array $actions)                    操作区
 * @method $this settings(array $settings)                  设置区
 * @method $this filter(array $filter)                      过滤区，通常配合 LightFilter 使用
 * @method $this multipleLine(boolean $multipleLine)        是否多行展示
 * @method $this menu(array $menu)                          菜单配置
 * @method $this tabs(array $tabs)                          标签页配置，仅当 multipleLine 为 true 时有效
 */
class Toolbar extends Renderer
{
    /**
     * @var string
     */
    public string $renderer = 'table-toolbar';
}