<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd 悬浮按钮
 * @link https://ant.design/components/float-button-cn
 * @method $this duration(int $value)                           回到顶部所需时间（ms）
 * @method $this visibilityHeight(int $value)                   滚动高度达到此参数值才出现 BackTop
 */
class FloatButtonBackTop extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'float-button-backTop';
}