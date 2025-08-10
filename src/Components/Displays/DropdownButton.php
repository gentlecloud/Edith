<?php
namespace Edith\Admin\Components\Displays;

/**
 * Antd DropdownButton
 * @link https://ant-design.antgroup.com/components/dropdown-cn
 * @method $this icon(string $value)                           右侧的 icon
 * @method $this size(string $value)                           按钮大小，和 Button 一致	large | middle | small
 * @method $this type(string $value)                           按钮类型，和 Button 一致	primary | dashed | link | text | default
 */
class DropdownButton extends Dropdown
{
    /**
     * @var string
     */
    protected string $renderer = 'dropdown-button';


    /**
     * 设置按钮载入状态，和 Button 一致
     * boolean | { delay: number, icon: ReactNode }
     * @param bool $value
     * @return self
     */
    public function loading(bool|array $value = true): self
    {
        $this->set('loading', $value);
        return $this;
    }

    /**
     * 设置危险按钮
     * @param bool $value
     * @return self
     */
    public function danger(bool $value = true): self
    {
        $this->set('danger', $value);
        return $this;
    }
}