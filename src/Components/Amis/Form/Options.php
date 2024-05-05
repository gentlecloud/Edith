<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis Form 选择器表单项
 * 参考文档：https://aisuda.bce.baidu.com/amis/zh-CN/components/form/options
 * @method $this options(array $options)                                    选项组，供用户选择
 * @method $this source($source)                                            选项组源，可通过数据映射获取当前数据域变量、或者配置 API 对象
 * @method $this labelField(string $labelField)                             标识选项中哪个字段是label值 默认： "label"
 * @method $this valueField(string $valueField)                             标识选项中哪个字段是value值 默认： "value"
 * @method $this itemHeight(int $itemHeight)                                每个选项的高度，用于虚拟渲染 默认： 32
 * @method $this virtualThreshold(int $virtualThreshold)                    在选项数量超过多少时开启虚拟渲染 默认： 100
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class Options extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'options';

    /**
     * 是否支持多选
     * @default false
     * @param bool $multiple
     * @return Options
     */
    public function multiple(bool $multiple = true): Options
    {
        return $this->set('multiple', $multiple);
    }

    /**
     * 是否拼接value值
     * @default true
     * @param bool $joinValues
     * @return Options
     */
    public function joinValues(bool $joinValues = true): Options
    {
        return $this->set('joinValues', $joinValues);
    }

    /**
     * 是否将value值抽取出来组成新的数组，只有在joinValues是false是生效
     * @default false
     * @param bool $extractValue
     * @return Options
     */
    public function extractValue(bool $extractValue = true): Options
    {
        return $this->set('extractValue', $extractValue);
    }

    /**
     * 默认情况下多选所有选项都会显示，通过这个可以最多显示一行，超出的部分变成 ...
     * @default false
     * @param bool $valuesNoWrap
     * @return Options
     */
    public function valuesNoWrap(bool $valuesNoWrap = true): Options
    {
        return $this->set('valuesNoWrap', $valuesNoWrap);
    }
}