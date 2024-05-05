<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis Static 静态展示
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/static
 * @method $this tpl(string $tpl)
 * @method $this map(array $map)
 * @method $this thumbMode(string $thumbMode)
 * @method $this thumbRatio(string $thumbRatio)
 * @method $this imageCaption(string $imageCaption)
 * @method $this enlargeAble(bool $enlargeAble)
 * @method $this popOver(array $popOver)
 * @method $this originalSrc(string $originalSrc)
 * @method $this copyable(array $copyable)
 * @method $this quickEdit($quickEdit)
 */
class InputStatic extends FormItem
{
    /**
     * @var string 
     */
    protected string $type = 'static';
}