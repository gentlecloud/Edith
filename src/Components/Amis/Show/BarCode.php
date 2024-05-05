<?php
namespace Gentle\Edith\Components\Amis\Show;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis BarCode条形码
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/barcode
 * @method $this value(string $value)                             显示的颜色值
 * @method $this name(string $name)                               在其他组件中，时，用作变量映射
 * @method $this options(array $options)                          条形码配置 {"format": "pharmacode","lineColor": "#0aa","width": "4","height": "40"}
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class BarCode extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'barcode';
}