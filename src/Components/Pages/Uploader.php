<?php
namespace Gentle\Edith\Components\Pages;

use Gentle\Edith\Components\Renderer;

/**
 * Ant ProCard
 * Ant 页内容器卡片，提供标准卡片样式，卡片切分以及栅格布局能力。ProCard 创造性地将 Col, Row, Card, Tabs 等组件实现结合在一起，让你仅用一个组件就能够完成卡片相关的各种布局。
 * @link https://procomponents.ant.design/components/card
 * @method $this title(string $title)                                 标题
 * @method $this subTitle(string $subTitle)                           副标题
 * @method $this tooltip(string $tooltip)                             标题右侧图标 hover 提示信息
 * @method $this headStyle(array $headStyle)                          标题的 style 样式
 * @method $this bodyStyle(array $bodyStyle)                          内容区的 style 样式
 * @method $this extra($extra)                                        右上角自定义区域
 * @method $this layout(string $layout)                               内容布局，支持垂直居中， default | center  默认： default
 * @method $this colSpan($colSpan)                                    栅格布局宽度，24 栅格，支持指定宽度 px 或百分比, 支持响应式的对象写法 { xs: 8, sm: 16, md: 24}, 仅在嵌套的子卡片上设置有效。 默认： 24
 * @method $this gutter($gutter)                                      数字或使用数组形式同时设置 [水平间距, 垂直间距], 支持响应式的对象写法 { xs: 8, sm: 16, md: 24} 默认： 0
 * @method $this split(string $split)                                 拆分卡片的方向  vertical | horizontal
 * @method $this type(string $type)                                   卡片类型  inner | default
 * @method $this size(string $size)                                   卡片尺寸	 default | small
 * @method $this direction(string $direction)                         指定 Flex 方向，仅在嵌套子卡片时有效，默认方向为 row 横向,  column
 */
class Uploader extends Renderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'edith';

    /**
     * Edith 渲染类型
     * @var string
     */
    protected string $component = 'uploader';
}