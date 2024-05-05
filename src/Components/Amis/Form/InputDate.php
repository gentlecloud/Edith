<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis Form InputDate 日期
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-date
 * @method $this format(string $format)                          日期选择器值格式，更多格式类型请参考 文档
 * @method $this inputFormat(string $inputFormat)                日期选择器显示格式，即时间戳格式，更多格式类型请参考 文档
 * @method $this placeholder(string $placeholder)                占位文本
 * @method $this shortcuts(string $shortcuts)                    日期快捷键
 * @method $this minDate(string $minDate)                        限制最小日期
 * @method $this maxDate(string $maxDate)                        限制最大日期
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class InputDate extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string 
     */
    protected string $type = 'input-date';

    /**
     * 点选日期后，是否马上关闭选择框
     * @default false
     * @param bool $closeOnSelect
     * @return InputDate
     */
    public function closeOnSelect(bool $closeOnSelect = true): InputDate
    {
        return $this->set('closeOnSelect', $closeOnSelect);
    }

    /**
     * 保存 utc 值
     * @default false
     * @param bool $utc
     * @return InputDate
     */
    public function utc(bool $utc = true): InputDate
    {
        return $this->set('utc', $utc);
    }

    /**
     * 是否可清除
     * @default true
     * @param bool $clearable
     * @return InputDate
     */
    public function clearable(bool $clearable = true): InputDate
    {
        return $this->set('clearable', $clearable);
    }

    /**
     * 是否内联模式
     * @default false
     * @param bool $embed
     * @return InputDate
     */
    public function embed(bool $embed = true): InputDate
    {
        return $this->set('embed', $embed);
    }
}