<?php
namespace Edith\Admin\Components\Amis\Page;

use Edith\Admin\Components\Amis\AmisRenderer;

/**
 * Amis Property 属性表
 * 使用表格的方式显示只读信息，如产品详情页。
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/property
 * @method $this labelStyle(array $labelStyle)                          属性名的样式
 * @method $this contentStyle(array $contentStyle)                      属性值的样式
 * @method $this column(int $column)                                     每行几列  默认： 3
 * @method $this mode(string $mode)                                      显示模式，目前只有 'table' 和 'simple' 默认： table
 * @method $this separator(string $separator)                            'simple' 模式下属性名和值之间的分隔符  默认： ,
 * @method $this title(string $title)                                    标题
 * @method $this source(string $source)                                  数据源
 * @method $this items(array $items)                                     属性
 * @author Chico
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Property extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'property';

    public function item()
    {

    }
}