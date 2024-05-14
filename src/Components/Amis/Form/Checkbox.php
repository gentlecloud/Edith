<?php
namespace Edith\Admin\Components\Amis\Form;

use Edith\Admin\Exceptions\RendererException;

/**
 * Amis Form Checkbox 勾选框
 * 用于实现勾选，功能和 Switch 类似，只是展现上不同。
 * 参考文档：  https://aisuda.bce.baidu.com/amis/zh-CN/components/form/checkbox
 * @method $this option(string $option)                           选项说明
 * @method $this trueValue($trueValue)                            标识真值  string｜number｜boolean  默认： true
 * @method $this falseValue($falseValue)                          标识假值  string｜number｜boolean  默认： false
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class Checkbox extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'checkbox';

    /**
     * 设置 option 类型
     * @default default
     * @param string $optionType default｜button
     * @return Checkbox
     * @throws RendererException
     */
    public function optionType(string $optionType): Checkbox
    {
        if (!in_array($optionType, ['default', 'button'])) {
            throw new RendererException("Option type only supports 'default' | 'button'");
        }
        return $this->set('optionType', $optionType);
    }
}