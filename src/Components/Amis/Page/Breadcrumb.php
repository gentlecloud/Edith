<?php
namespace Gentle\Edith\Components\Amis\Page;

use Gentle\Edith\Components\Amis\AmisRenderer;
use Gentle\Edith\Exceptions\RendererException;

/**
 * Amis Breadcrumb 面包屑
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/breadcrumb
 * @method $this itemClassName(string $itemClassName)                         导航项类名
 * @method $this separatorClassName(string $separatorClassName)               分割符类名
 * @method $this dropdownClassName(string $dropdownClassName)                 下拉菜单类名
 * @method $this dropdownItemClassName(string $dropdownItemClassName)         下拉菜单项类名
 * @method $this separator(string $separator)                                 分隔符
 * @method $this labelMaxLength(int $labelMaxLength)                          最大展示长度 默认： 16
 * @method $this source(string $source)                                       动态数据
 * @method $this items(array $items)
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Breadcrumb extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'breadcrumb';

    /**
     * 浮窗提示位置
     * @default top
     * @param string $tooltipPosition top | bottom | left | right
     * @return Breadcrumb
     * @throws RendererException
     */
    public function tooltipPosition(string $tooltipPosition): Breadcrumb
    {
        if (!in_array($tooltipPosition, ['top', 'bottom', 'left', 'right'])) {
            throw new RendererException("Breadcrumb tooltip position only supports top, bottom, left or right");
        }
        return $this->set('tooltipPosition', $tooltipPosition);
    }
}