<?php
namespace Edith\Admin\Components\Actions;

use Edith\Admin\Components\Displays\Iconfont;
use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Drawer
 * @link https://ant.design/components/drawer-cn
 * @method $this classNames(array $value)                               语义化结构 className	Record<SemanticDOM, string>
 * @method $this closeIcon(string|Iconfont $value)                      自定义关闭图标。5.7.0：设置为 null 或 false 时隐藏关闭按钮
 * @method $this extra(array $value)                                    抽屉右上角的操作区域
 * @method $this footer(array $value)                                   抽屉的页脚
 * @method $this getContainer(string|bool $value)                       指定 Drawer 挂载的节点，并在容器内展现，false 为挂载在当前位置
 * @method $this height(string|int $value)                              高度，在 placement 为 top 或 bottom 时使用
 * @method $this placement(string $value)                               抽屉的方向	top | right | bottom | left
 * @method $this rootStyle(array $value)                                可用于设置 Drawer 最外层容器的样式，和 style 的区别是作用节点包括 mask
 * @method $this styles(array $value)                                   语义化结构 style
 * @method $this size(string $value)                                    预设抽屉宽度（或高度），default 378px 和 large 736px
 * @method $this title(string $value)                                   标题
 * @method $this width(string $value)                                   宽度
 * @method $this zIndex(int $value)                                     设置 Drawer 的 z-index
 */
class Drawer extends EngineRenderer
{
    /**
     * @var string
     */
    public string $renderer = 'drawer';

    /**
     * 按钮
     * @var Button|null
     */
    protected ?Button $button;

    /**
     * construct Drawer
     */
    public function __construct(?string $button = '', ?string $title = null)
    {
        parent::__construct();
        $this->button = new Button($button);
        !is_null($title) && $this->title($title);
    }

    /**
     * 抽屉展开后是否将焦点切换至其 DOM 节点
     * @param bool $value
     * @return self
     */
    public function autoFocus(bool $value = true): self
    {
        return $this->set('autoFocus', $value);
    }

    /**
     * 关闭时销毁 Drawer 里的子元素
     * @param bool $value
     * @return self
     */
    public function destroyOnHidden(bool $value = true): self
    {
        return $this->set('destroyOnHidden', $value);
    }

    /**
     * 预渲染 Drawer 内元素
     * @param bool $value
     * @return self
     */
    public function forceRender(bool $value = true): self
    {
        return $this->set('forceRender', $value);
    }

    /**
     * 是否支持键盘 esc 关闭
     * @param bool $value
     * @return self
     */
    public function keyboard(bool $value = true): self
    {
        return $this->set('keyboard', $value);
    }

    /**
     * 是否展示遮罩
     * @param bool $value
     * @return self
     */
    public function mask(bool $value = true): self
    {
        return $this->set('mask', $value);
    }

    /**
     * 点击蒙层是否允许关闭
     * @param bool $value
     * @return self
     */
    public function maskClosable(bool $value = true): self
    {
        return $this->set('maskClosable', $value);
    }

    /**
     * 用于设置多层 Drawer 的推动行为
     * @param bool $value
     * @return self
     * @example boolean | { distance: string | number }
     */
    public function push(bool|array $value = true): self
    {
        return $this->set('push', $value);
    }

    /**
     * 显示骨架屏
     * @param bool $value
     * @return self
     */
    public function loading(bool $value = true): self
    {
        return $this->set('loading', $value);
    }

    /**
     * Drawer 是否可见
     * @param bool $value
     * @return self
     */
    public function open(bool $value = true): self
    {
        return $this->set('open', $value);
    }
}