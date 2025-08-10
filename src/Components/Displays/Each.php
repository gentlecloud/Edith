<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;
use Edith\Admin\Components\Layouts\Space;

/**
 * @method $this name(string $name)                              获取数据域中变量
 * @method $this source(string $source)                          获取数据域中变量， 支持 数据映射
 * @method $this items(array|object $items)                      使用value中的数据，循环输出渲染器。
 * @method $this placeholder(string $placeholder)                当 value 值不存在或为空数组时的占位文本
 */
class Each extends EngineRenderer
{
    /**
     * 翼搭 UI 渲染组件
     * @var string
     */
    protected string $renderer = 'each';

    /**
     * @param Space $space
     * @return self
     */
    public function withSpace(Space $space): self
    {
        return $this->set('space', $space);
    }
}