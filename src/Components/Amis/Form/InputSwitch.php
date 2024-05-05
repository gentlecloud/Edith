<?php
namespace Gentle\Edith\Components\Amis\Form;

use Gentle\Edith\Exceptions\RendererException;

/**
 * Amis 表单项开关
 * 参考文档：https://aisuda.bce.baidu.com/amis/zh-CN/components/form/switch
 * @method $this option(string $option)                                 选项说明
 * @method $this onText(string $onText)                                 开启时的文本
 * @method $this offText(string $offText)                               关闭时的文本
 * @method $this trueValue($trueValue)                                  标识真值 默认： true
 * @method $this falseValue($falseValue)                                标识假值 默认： "false"
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class InputSwitch extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'switch';

    /**
     * 开关大小
     * @default md
     * @param string $size sm | md
     * @return InputSwitch
     * @throws RendererException
     */
    public function size(string $size): InputSwitch
    {
        if (!in_array($size, ['sm', 'md'])) {
            throw new RendererException('Switch size only supports sm or md');
        }
        return $this->set('size', $size);
    }
}