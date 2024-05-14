<?php
namespace Edith\Admin\Components\Amis\Show;

use Edith\Admin\Components\Amis\AmisRenderer;

/**
 * Amis Each 循环渲染器
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/each
 * @method $this value(array $value)                       用于循环的值
 * @method $this name(string $name)                        获取数据域中变量
 * @method $this source(string $source)                    获取数据域中变量， 支持 数据映射
 * @method $this items(array $items)                       使用value中的数据，循环输出渲染器。
 * @method $this placeholder(string $placeholder)          当 value 值不存在或为空数组时的占位文本
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Each extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'each';
}