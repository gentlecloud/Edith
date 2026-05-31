<?php
namespace Edith\Admin\Components\Layouts;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Splitter
 * @link https://ant.design/components/splitter-cn
 * @method $this defaultSize(string $value)                              初始面板大小，支持数字 px 或者文字 '百分比%' 类型
 * @method $this min(string $value)                                      最小阈值，支持数字 px 或者文字 '百分比%' 类型
 * @method $this max(string $value)                                      最大阈值，支持数字 px 或者文字 '百分比%' 类型
 * @method $this size(string $value)                                     受控面板大小，支持数字 px 或者文字 '百分比%' 类型
 */
class SplitterPanel extends EngineRenderer
{
    /**
     * @var string
     */
    public string $renderer = 'splitter-panel';

    /**
     * 快速折叠
     * @param bool $value
     * @return self
     */
    public function collapsible(bool $value = true): self
    {
        return $this->set('collapsible', $value);
    }

    /**
     * 是否开启拖拽伸缩
     * @param bool $value
     * @return self
     */
    public function resizable(bool $value = true): self
    {
        return $this->set('resizable', $value);
    }
}