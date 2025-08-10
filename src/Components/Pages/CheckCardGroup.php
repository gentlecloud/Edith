<?php
namespace Edith\Admin\Components\Pages;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd CheckCard
 * @link https://procomponents.ant.design/components/check-card
 * @method $this defaultValue(string|array $value)                  默认选中的选项
 * @method $this options(array $value)                              指定可选项	string[] | Array<{ title: ReactNode, value: string, description?: ReactNode, avatar?: link or ReactNode, cover?:ReactNode, disabled?: boolean }>
 * @method $this value(string|string $value)                        指定选中的选项
 * @method $this size(string $value)                                选择框大小，可选 large small default
 */
class CheckCardGroup extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'check-card-group';

    /**
     * 多选
     * @param bool $multiple
     * @return self
     */
    public function multiple(bool $multiple = true): self
    {
        return $this->set('multiple', $multiple);
    }

    /**
     * 是否显示边框
     * @param bool $bordered
     * @return self
     */
    public function bordered(bool $bordered = true): self
    {
        return $this->set('bordered', $bordered);
    }

    /**
     * 整组失效
     * @param bool $disabled
     * @return self
     */
    public function disabled(bool $disabled = true): self
    {
        return $this->set('disabled', $disabled);
    }

    /**
     * 当卡片内容还在加载中时，可以用 loading 展示一个占位
     * @param bool $loading
     * @return self
     */
    public function loading(bool $loading = true): self
    {
        return $this->set('loading', $loading);
    }
}