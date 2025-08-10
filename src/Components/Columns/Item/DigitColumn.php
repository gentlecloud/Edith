<?php
namespace Edith\Admin\Components\Columns\Item;

use Edith\Admin\Components\Columns\Column;

/**
 * Antd Input-Number
 * @link https://ant-design.antgroup.com/components/input-number-cn
 * @method $this decimalSeparator(string $value)                                小数点
 * @method $this max(int $value)                                                最大值
 * @method $this min(int $value)                                                最小值
 * @method $this precision(int $value)                                          数值精度，配置 formatter 时会以 formatter 为准
 * @method $this step(int|string $value)                                        每次改变步数，可以为小数
 */
class DigitColumn extends Column
{
    /**
     * construct Digit Column
     * @param string|null $dataIndex
     * @param string|null $title
     */
    public function __construct(?string $dataIndex = null, ?string $title = null)
    {
        parent::__construct($dataIndex, $title, 'digit');
    }

    /**
     * 是否在失去焦点时，触发 onChange 事件（例如值超出范围时，重新限制回范围并触发事件）
     * @param bool $value
     * @return self
     */
    public function changeOnBlur(bool $value): self
    {
        return $this->fieldProp('changeOnBlur', $value);
    }

    /**
     * 允许鼠标滚轮改变数值
     * @param bool $value
     * @return self
     */
    public function changeOnWheel(bool $value): self
    {
        return $this->fieldProp('changeOnWheel', $value);
    }

    /**
     * 是否启用键盘快捷行为
     * @param bool $value
     * @return self
     */
    public function keyboard(bool $value): self
    {
        return $this->fieldProp('keyboard', $value);
    }

    /**
     * 字符值模式，开启后支持高精度小数。同时 onChange 将返回 string 类型
     * @param bool $value
     * @return self
     */
    public function stringMode(bool $value): self
    {
        return $this->fieldProp('stringMode', $value);
    }

    /**
     * 是否显示增减按钮，也可设置自定义箭头图标	boolean | { upIcon?: React.ReactNode; downIcon?: React.ReactNode; }
     * @param bool $value
     * @return self
     */
    public function controls(bool $value): self
    {
        return $this->fieldProp('controls', $value);
    }
}