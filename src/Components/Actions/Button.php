<?php
namespace Edith\Admin\Components\Actions;

/**
 * Antd Button
 * @link
 * @method $this classNames(string $value)                                  语义化结构 class
 * @method $this shape(string $value)                                       设置按钮形状	default | circle | round
 */
class Button extends Action
{
    /**
     * @var string
     */
    protected string $actionType = 'button';

    /**
     * 我们默认提供两个汉字之间的空格，可以设置 autoInsertSpace 为 false 关闭
     * @param bool $value
     * @return self
     */
    public function autoInsertSpace(bool $value = true): self
    {
        return $this->set('autoInsertSpace', $value);
    }

    /**
     * 将按钮宽度调整为其父宽度的选项
     * @param bool $value
     * @return self
     */
    public function block(bool $value = true): self
    {
        return $this->set('block', $value);
    }
}