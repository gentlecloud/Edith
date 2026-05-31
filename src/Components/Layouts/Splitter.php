<?php
namespace Edith\Admin\Components\Layouts;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Splitter
 * @link https://ant.design/components/splitter-cn
 * @method $this layout(string $value)                              布局方向	horizontal | vertical
 */
class Splitter extends EngineRenderer
{
    /**
     * @var string 
     */
    public string $renderer = 'splitter';

    /**
     * 延迟渲染模式
     * @param bool $value
     * @return self
     */
    public function lazy(bool $value = true): self
    {
        return $this->set('lazy', $value);
    }
}