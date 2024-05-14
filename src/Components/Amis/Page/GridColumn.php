<?php
namespace Edith\Admin\Components\Amis\Page;

use Edith\Admin\Components\BaseRenderer;
use Edith\Admin\Exceptions\RendererException;

/**
 * Amis Grid Column
 * @method $this xs($xs)                                         宽度占比： 1 - 12  int or "auto"
 * @method $this columnClassName(string $columnClassName)        列类名
 * @method $this sm($sm)                                         int or "auto"
 * @method $this md($md)                                         int or "auto"
 * @method $this lg($lg)                                         int or "auto"
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class GridColumn extends BaseRenderer
{

    /**
     * 当前列内容的垂直对齐
     * @param string $valign 'top' | 'middle' | 'bottom' | 'between'
     * @return GridColumn
     * @throws RendererException
     */
    public function valign(string $valign): GridColumn
    {
        if (!in_array($valign, ['top', 'middle', 'bottom', 'between'])) {
            throw new RendererException("Grid column valign only supports 'top', 'middle', 'bottom' and 'between'");
        }
        return $this->set('valign', $valign);
    }
}