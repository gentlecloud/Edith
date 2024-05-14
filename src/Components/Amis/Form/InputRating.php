<?php
namespace Edith\Admin\Components\Amis\Form;

use Edith\Admin\Exceptions\RendererException;

/**
 * Amis InputRating 评分
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-rating
 * @method $this count(int $count)                     总星数 默认： 5
 * @method $this colors($colors)                       {'2': '#abadb1', '3': '#787b81', '5': '#ffa900' } 星星被选中的颜色。 若传入字符串，则只有一种颜色。若传入对象，可自定义分段，键名为分段的界限值，键值为对应的类名
 * @method $this inactiveColor(string $inactiveColor)  未被选中的星星的颜色 默认： #e7e7e8
 * @method $this texts(array $texts)                   星星被选中时的提示文字。可自定义分段，键名为分段的界限值，键值为对应的类名
 * @method $this char(string $char)                    自定义字符 默认： *
 * @method $this charClassName(string $charClassName)  自定义字符类名
 * @method $this textClassName(string $textClassName)  自定义文字类名
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class InputRating extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-rating';

    /**
     * 是否使用半星选择
     * @default false
     * @param bool $half
     * @return InputRating
     */
    public function half(bool $half = true): InputRating
    {
        return $this->set('half', $half);
    }

    /**
     * 只读
     * @default false
     * @param bool $readOnly
     * @return InputRating
     */
    public function readOnly(bool $readOnly = true): InputRating
    {
        return $this->set('readOnly', $readOnly);
    }

    /**
     * 是否允许再次点击后清除
     * @default true
     * @param bool $allowClear
     * @return InputRating
     */
    public function allowClear(bool $allowClear = true): InputRating
    {
        return $this->set('allowClear', $allowClear);
    }

    /**
     * 文字的位置
     * @param string $textPosition left | right
     * @return InputRating
     * @throws RendererException
     */
    public function textPosition(string $textPosition): InputRating
    {
        if (!in_array($textPosition, ['left', 'right'])) {
            throw new RendererException("Text position only supports left or right");
        }
        return $this->set('textPosition', $textPosition);
    }
}