<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Alert警告提示
 * @link https://ant.design/components/alert-cn
 * @method $this action(array $actions)                             自定义操作项
 * @method $this description(string $value)                         警告提示的辅助性文字介绍
 * @method $this message(string $value)                             警告提示内容
 * @method $this type(string $value)                                指定警告提示的样式，有四种选择 success、info、warning、error
 */
class Alert extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'alert';

    /**
     * @param string|Iconfont $icon
     * @return self
     */
    public function icon(string|Iconfont $icon): self
    {
        $this->showIcon();
        return $this->set('icon', $icon);
    }

    /**
     * 可关闭配置
     * @param bool|array $value
     * @return self
     * @example boolean | ({ closeIcon?: React.ReactNode } & React.AriaAttributes)
     */
    public function closable(bool|array $value = true): self
    {
        return $this->set('closable', $value);
    }

    /**
     * 是否用作顶部公告
     * @param bool $value
     * @return self
     */
    public function banner(bool $value = true): self
    {
        return $this->set('banner', $value);
    }

    /**
     * 是否显示辅助图标
     * @param bool $value
     * @return self
     */
    public function showIcon(bool $value = true): self
    {
        return $this->set('showIcon', $value);
    }
}