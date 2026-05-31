<?php
namespace Edith\Admin\Components\Actions;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Modal
 * @link
 * @method $this afterClose(string $js)                             Modal 完全关闭后的回调
 * @method $this styles(array $styles)                              配置弹窗内置模块的 style
 * @method $this cancelText(string $cancelText)                     设置 Modal.confirm 取消按钮文字
 * @method $this closeIcon(string $closeIcon)                       自定义关闭图标。设置为 null 或 false 时隐藏关闭按钮
 * @method $this footer(null|array|object $footer)                       底部内容，当不需要默认底部按钮时，可以设为 footer={null}	ReactNode | (originNode: ReactNode, extra: { OkBtn: React.FC, CancelBtn: React.FC }) => ReactNode
 * @method $this getContainer(string $js)                           指定 Modal 挂载的节点，但依旧为全屏展示，false 为挂载在当前位置	HTMLElement | () => HTMLElement | Selectors | false
 * @method $this keyboard(bool $keyboard)                           是否支持键盘 esc 关闭 默认为 True
 * @method $this mask(bool $mask)                                   是否展示遮罩 默认为 True
 * @method $this maskClosable(bool $maskClosable)                   点击蒙层是否允许关闭 默认为 True
 * @method $this modalRender(array $modalRender)                    自定义渲染对话框
 * @method $this okText(string $okText)                             确认按钮文字
 * @method $this okType(string $okText)                             确认按钮类型
 * @method $this title(string $okText)                              标题
 * @method $this wrapClassName(string $okText)                      对话框外层容器的类名
 * @method $this zIndex(int $zIndex)                                设置 Modal 的 z-index
 */
class Modal extends EngineRenderer
{
    /**
     * @var string
     */
    public string $renderer = 'modal';

    /**
     * 按钮
     * @var Button|null
     */
    protected ?Button $button;

    /**
     * 默认对话框不可见
     * @var bool
     */
    protected bool $open = false;


    /**
     * 默认关闭确定按钮 loading
     * @var bool
     */
    protected bool $confirmLoading = false;

    /**
     * construct MODAL
     */
    public function __construct(?string $button = '', ?string $title = null)
    {
        parent::__construct();
        $this->button = new Button($button);
        !is_null($title) && $this->title($title);
    }

    /**
     * cancel 按钮 props
     * @param array|object $props Button Props
     * @return $this
     */
    public function cancelButtonProps(array|object $props): self
    {
        $this->set('cancelButtonProps', $props);
        return $this;
    }

    /**
     * 垂直居中展示 Modal
     * @param bool $value
     * @return self
     */
    public function centered(bool $value = true): self
    {
        return $this->set('centered', $value);
    }

    /**
     * 确定按钮 loading 启用异步回调
     * @param bool $value
     * @return self
     */
    public function confirmLoading(bool $value = true): self
    {
        return $this->set('confirmLoading', $value);
    }

    /**
     * 是否显示右上角的关闭按钮	boolean | { closeIcon?: React.ReactNode; disabled?: boolean; }
     * @param bool|array $value
     * @return self
     */
    public function closable(bool|array $value = true): self
    {
        return $this->set('closable', $value);
    }

    /**
     * 关闭时销毁 Modal 里的子元素
     * @param bool $value
     * @return self
     */
    public function destroyOnHidden(bool $value = true): self
    {
        return $this->set('destroyOnHidden', $value);
    }

    /**
     * 对话框关闭后是否需要聚焦触发元素
     * @param bool $value
     * @return self
     */
    public function focusTriggerAfterClose(bool $value = false): self
    {
        return $this->set('focusTriggerAfterClose', $value);
    }

    /**
     * 强制渲染 Modal
     * @param bool $value
     * @return self
     */
    public function forceRender(bool $value = true): self
    {
        return $this->set('forceRender', $value);
    }

    /**
     * ok 按钮 props
     * @param array|object $props Button Props
     * @return $this
     */
    public function okButtonProps(array|object $props): self
    {
        $this->set('okButtonProps', $props);
        return $this;
    }

    /**
     * 显示骨架屏
     * @param bool $value
     * @return $this
     */
    public function loading(bool $value): self
    {
        $this->set('loading', $value);
        return $this;
    }

    /**
     * 关闭销毁
     * @param bool $value
     * @return $this
     */
    public function destroyOnClose(bool $value = true): self
    {
        $this->set('destroyOnClose', $value);
        return $this;
    }

    /**
     * 对话框是否可见
     * @param bool $value
     * @return $this
     */
    public function open(bool $value): self
    {
        $this->set('open', $value);
        return $this;
    }
}