<?php
namespace Edith\Admin\Components\Pages;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd CheckCard
 * @link https://procomponents.ant.design/components/check-card
 * @method $this value(string $value)                               选项值
 * @method $this size(string $value)                                选择框大小，可选 large | small 默认：default
 * @method $this title(string $value)                               标题
 * @method $this description(string $value)                         描述
 * @method $this avatar(string $value)                              选项元素的图片地址
 * @method $this extra(array $value)                                动作区域
 * @method $this cover(string $value)                               卡片背景图片，注意使用该选项后title，description和avatar失效
 */
class CheckCard extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'check-card';

    /**
     * 指定当前是否选中
     * @param bool $checked
     * @return self
     */
    public function checked(bool $checked = true): self
    {
        return $this->set('checked', $checked);
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
     * 初始是否选中
     * @param bool $defaultChecked
     * @return self
     */
    public function defaultChecked(bool $defaultChecked = true): self
    {
        return $this->set('defaultChecked', $defaultChecked);
    }

    /**
     * 失效状态
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