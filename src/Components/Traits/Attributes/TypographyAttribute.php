<?php
namespace Edith\Admin\Components\Traits\Attributes;

use Edith\Admin\Components\Displays\Iconfont;
use Edith\Admin\Components\Displays\Link;
use Edith\Admin\Components\Displays\Text;
use Edith\Admin\Components\Displays\Title;

/**
 * @method $this text(string $text)
 * @method $this type(string $type)
 * @method $this icon(string|Iconfont $icon)
 * @method $this iconStyle(array $style)
 */
trait TypographyAttribute
{

    /**
     * 添加代码样式
     * @param bool $code
     * @return Text|Link|Title|TypographyAttribute
     */
    public function code(bool $code = true): self
    {
        return $this->set('code', $code);
    }

    /**
     * 是否可拷贝，为对象时可进行各种自定义    boolean | copyable
     * @param bool|array $copyable
     * @return Text|Link|Title|TypographyAttribute
     */
    public function copyable(bool|array $copyable = true): self
    {
        return $this->set('copyable', $copyable);
    }

    /**
     * 添加删除线样式
     * @param bool $delete
     * @return Text|Link|Title|TypographyAttribute
     */
    public function delete(bool $delete = true): self
    {
        return $this->set('delete', $delete);
    }

    /**
     * 禁用文本
     * @param bool $disabled
     * @return Text|Link|Title|TypographyAttribute
     */
    public function disabled(bool $disabled = true): self
    {
        return $this->set('disabled', $disabled);
    }

    /**
     * 是否可编辑，为对象时可对编辑进行控制	boolean | editable
     * @param bool|array $editable
     * @return Text|Link|Title|TypographyAttribute
     */
    public function editable(bool|array $editable = true): self
    {
        return $this->set('editable', $editable);
    }

    /**
     * 自动溢出省略，为对象时不能设置省略行数、是否可展开、onExpand 展开事件。不同于 Typography.Paragraph，Text 组件自身不带 100% 宽度样式，因而默认情况下初次缩略后宽度便不再变化。如果需要自适应宽度，请手动配置宽度样式	boolean | Omit<ellipsis, 'expandable' | 'rows' | 'onExpand'>
     * @param bool|array $ellipsis
     * @return Text|Link|Title|TypographyAttribute
     */
    public function ellipsis(bool|array $ellipsis = true): self
    {
        return $this->set('ellipsis', $ellipsis);
    }

    /**
     * 添加标记样式
     * @param bool $mark
     * @return Text|Link|Title|TypographyAttribute
     */
    public function mark(bool $mark = true): self
    {
        return $this->set('mark', $mark);
    }

    /**
     * 是否加粗
     * @param bool $strong
     * @return Text|Link|Title|TypographyAttribute
     */
    public function strong(bool $strong = true): self
    {
        return $this->set('strong', $strong);
    }

    /**
     * 是否斜体
     * @param bool $italic
     * @return Text|Link|Title|TypographyAttribute
     */
    public function italic(bool $italic = true): self
    {
        return $this->set('italic', $italic);
    }

    /**
     * 添加下划线样式
     * @param bool $underline
     * @return Text|Link|Title|TypographyAttribute
     */
    public function underline(bool $underline = true): self
    {
        return $this->set('underline', $underline);
    }
}