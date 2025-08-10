<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;
use Edith\Admin\Components\Layouts\Menu;

/**
 * Antd Dropdown
 * @link https://ant-design.antgroup.com/components/dropdown-cn
 * @method $this disabledOn(string $disabledOn)                     菜单是否禁用条件
 * @method $this popupRender($popupRender)                          自定义弹出框内容	(menus: ReactNode) => ReactNode
 * @method $this overlayClassName(string $overlayClassName)         下拉根元素的类名称
 * @method $this overlayStyle(array $overlayStyle)                  下拉根元素的样式	CSSProperties
 * @method $this placement(string $placement)                       菜单弹出位置：bottom bottomLeft bottomRight top topLeft topRight
 * @method $this trigger(array $trigger)                            触发下拉的行为，移动端不支持 hover	Array<click|hover|contextMenu>
 * @method $this open(bool $open)                                   菜单是否显示
 */
class Dropdown extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'dropdown';

    /**
     * @var string
     */
    protected string $title = '下拉菜单';

    /**
     * @var Menu|null
     */
    protected ?Menu $menu = null;

    /**
     * @param string|null $title
     */
    public function __construct(?string $title = null)
    {
        parent::__construct();
        !is_null($title) && $this->set('title', $title);
    }

    /**
     * 下拉框箭头是否显示	boolean | { pointAtCenter: boolean }
     * @param bool|array $value
     * @return self
     */
    public function arrow(bool|array $value = true): self
    {
        return $this->set('arrow', $value);
    }

    /**
     * 菜单是否禁用
     * @param bool $disabled
     * @return self
     */
    public function disabled(bool $disabled = true): self
    {
        return $this->set('disabled', $disabled);
    }

    /**
     * 关闭后是否销毁 Dropdown
     * @param bool $destroyOnHidden
     * @return self
     */
    public function destroyOnHidden(bool $destroyOnHidden = true): self
    {
        return $this->set('destroyOnHidden', $destroyOnHidden);
    }

    /**
     * 打开后自动聚焦下拉框
     * @param bool $autoFocus
     * @return self
     */
    public function autoFocus(bool $autoFocus = true): self
    {
        return $this->set('autoFocus', $autoFocus);
    }

    /**
     * 下拉框被遮挡时自动调整位置
     * @param bool $autoAdjustOverflow
     * @return self
     */
    public function autoAdjustOverflow(bool $autoAdjustOverflow = true): self
    {
        return $this->set('autoAdjustOverflow', $autoAdjustOverflow);
    }

    /**
     * @param \Closure $closure
     * @return $this
     */
    public function menu(\Closure $closure): self
    {
        $menu = new Menu();
        $closure($menu);
        $this->menu = $menu;
        return $this;
    }
}