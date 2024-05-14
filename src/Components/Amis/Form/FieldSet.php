<?php
namespace Edith\Admin\Components\Amis\Form;

use Edith\Admin\Exceptions\RendererException;

/**
 * Amis Form FieldSet 表单项集合
 * FieldSet 是用于分组展示表单项的一种容器型组件，可以折叠。
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/fieldset
 * @method $this headingClassName(string $headingClassName)                   标题 CSS 类名
 * @method $this bodyClassName(string $bodyClassName)                         内容区域 CSS 类名
 * @method $this mode(string $mode)                                           展示默认，同 Form 中的模式
 * @method $this collapseTitle($collapseTitle)                                收起的标题 默认： "收起"
 */
class FieldSet extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'fieldSet';

    /**
     * construct FieldSet
     * @param string|null $title
     */
    public function __construct(?string $title = null)
    {
        $this->set('title', $title);
        parent::__construct();
    }

    /**
     * 是否可折叠
     * @default false
     * @param bool $collapsable
     * @return FieldSet
     */
    public function collapsable(bool $collapsable = true): FieldSet
    {
        return $this->set('collapsable', $collapsable);
    }

    /**
     * 默认是否折叠
     * @default false
     * @param bool $collapsed
     * @return FieldSet
     */
    public function collapsed(bool $collapsed = true): FieldSet
    {
        return $this->set('collapsed', $collapsed);
    }

    /**
     * 大小
     * @param string $size  xs、sm、base、lg、xl
     * @return FieldSet
     * @throws RendererException
     */
    public function size(string $size): FieldSet
    {
        if (!in_array($size, ['xs', 'sm', 'base', 'lg', 'xl'])) {
            throw new RendererException("FieldSet size only supports  xs、sm、base、lg、xl");
        }
        return $this->set('size', $size);
    }
}
