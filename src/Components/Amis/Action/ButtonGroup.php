<?php
namespace Edith\Admin\Components\Amis\Action;

use Edith\Admin\Components\Amis\AmisRenderer;
use Edith\Admin\Exceptions\RendererException;

/**
 * Amis ButtonGroup 按钮组
 * 参考文档：  https://baidu.github.io/amis/zh-CN/components/button-group
 * @method $this vertical(bool $vertical)                           是否使用垂直模式  默认： false
 * @method $this tiled(bool $tiled)                                 是否使用平铺模式
 * @method $this buttons(array $buttons)                            按钮
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class ButtonGroup extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'button-group';

    /**
     * 按钮样式
     * @default default
     * @param string $btnLevel 'link' | 'primary' | 'secondary' | 'info'|'success' | 'warning' | 'danger' | 'light'| 'dark' | 'default'
     * @return ButtonGroup
     * @throws RendererException
     */
    public function btnLevel(string $btnLevel): ButtonGroup
    {
        if (!in_array($btnLevel, ['link', 'primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light', 'dark', 'default'])) {
            throw new RendererException("Button level only supports 'link' | 'primary' | 'secondary' | 'info'|'success' | 'warning' | 'danger' | 'light'| 'dark' | 'default'");
        }
        return $this->set('btnLevel', $btnLevel);
    }

    /**
     * 选中按钮样式
     * @default default
     * @param string $btnActiveLevel 'link' | 'primary' | 'secondary' | 'info'|'success' | 'warning' | 'danger' | 'light'| 'dark' | 'default'
     * @return ButtonGroup
     * @throws RendererException
     */
    public function btnActiveLevel(string $btnActiveLevel): ButtonGroup
    {
        if (!in_array($btnActiveLevel, ['link', 'primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light', 'dark', 'default'])) {
            throw new RendererException("Button action level only supports 'link' | 'primary' | 'secondary' | 'info'|'success' | 'warning' | 'danger' | 'light'| 'dark' | 'default'");
        }
        return $this->set('btnActiveLevel', $btnActiveLevel);
    }
}