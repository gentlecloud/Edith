<?php
declare(strict_types=1);
namespace Edith\Admin\Components\Traits\Fields;

use Edith\Admin\Components\Columns\Item\DigitColumn;
use Edith\Admin\Components\Fields\Item\Digit;

/**
 * Antd Input-Number
 * @link https://ant-design.antgroup.com/components/input-number-cn
 */
trait DigitAttribute
{
    /**
     * 最大值
     * @param int|numeric-string $value
     * @return Digit|DigitColumn|DigitAttribute
     */
    public function max(int|string $value): self
    {
        return $this->fieldProp('max', $value);
    }

    /**
     * 最小值
     * @param int|numeric-string $value
     * @return Digit|DigitColumn|DigitAttribute
     */
    public function min(int|string $value): self
    {
        return $this->fieldProp('min', $value);
    }

    /**
     * 数值精度，配置 formatter 时会以 formatter 为准
     * @param int|numeric-string $value
     * @return Digit|DigitColumn|DigitAttribute
     */
    public function precision(int|string $value): self
    {
        return $this->fieldProp('precision', $value);
    }

    /**
     * 每次改变步数，可以为小数
     * @param int $value
     * @return Digit|DigitColumn|DigitAttribute
     */
    public function step(int $value): self
    {
        return $this->fieldProp('step', $value);
    }

    /**
     * 小数点
     * @param string $value
     * @return Digit|DigitColumn|DigitAttribute
     */
    public function decimalSeparator(string $value): self
    {
        return $this->fieldProp('decimalSeparator', $value);
    }
    
    /**
     * 是否在失去焦点时，触发 onChange 事件（例如值超出范围时，重新限制回范围并触发事件）
     * @param bool $value
     * @return Digit|DigitColumn|DigitAttribute
     */
    public function changeOnBlur(bool $value): self
    {
        return $this->fieldProp('changeOnBlur', $value);
    }

    /**
     * 允许鼠标滚轮改变数值
     * @param bool $value
     * @return Digit|DigitColumn|DigitAttribute
     */
    public function changeOnWheel(bool $value): self
    {
        return $this->fieldProp('changeOnWheel', $value);
    }

    /**
     * 是否启用键盘快捷行为
     * @param bool $value
     * @return Digit|DigitColumn|DigitAttribute
     */
    public function keyboard(bool $value): self
    {
        return $this->fieldProp('keyboard', $value);
    }

    /**
     * 字符值模式，开启后支持高精度小数。同时 onChange 将返回 string 类型
     * @param bool $value
     * @return Digit|DigitColumn|DigitAttribute
     */
    public function stringMode(bool $value): self
    {
        return $this->fieldProp('stringMode', $value);
    }

    /**
     * 是否显示增减按钮，也可设置自定义箭头图标    boolean | { upIcon?: React.ReactNode; downIcon?: React.ReactNode; }
     * @param bool $value
     * @return Digit|DigitColumn|DigitAttribute
     */
    public function controls(bool $value): self
    {
        return $this->fieldProp('controls', $value);
    }
}