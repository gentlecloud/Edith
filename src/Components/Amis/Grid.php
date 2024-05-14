<?php
namespace Edith\Admin\Components\Amis;

use Edith\Admin\Components\Amis\Page\GridColumn;
use Edith\Admin\Exceptions\RendererException;
use Illuminate\Support\Collection;

/**
 * Amis Grid 水平布局
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/grid
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Grid extends AmisRenderer
{

    protected Collection $colomns;

    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'grid';

    public function __construct()
    {
        parent::__construct();
        $this->columns = new Collection();
    }

    /**
     * 水平间距
     * @param string $gap 'xs' | 'sm' | 'base' | 'none' | 'md' | 'lg'
     * @return Grid
     * @throws RendererException
     */
    public function gap(string $gap): Grid
    {
        if (!in_array($gap, ['xs', 'sm', 'base', 'none', 'md', 'lg'])) {
            throw new RendererException("Grid gap only supports 'xs' | 'sm' | 'base' | 'none' | 'md' | 'lg'");
        }
        return $this->set('gap', $gap);
    }

    /**
     * 垂直对齐方式
     * @param string $valign 'top' | 'middle' | 'bottom' | 'between'
     * @return Grid
     * @throws RendererException
     */
    public function valign(string $valign): Grid
    {
        if (!in_array($valign, ['top', 'middle', 'bottom', 'between'])) {
            throw new RendererException("Grid valign only supports 'top' | 'middle' | 'bottom' | 'between'");
        }
        return $this->set('valign', $valign);
    }

    /**
     * 水平对齐方式
     * @param string $align 'left' | 'right' | 'between' | 'center'
     * @return Grid
     * @throws RendererException
     */
    public function align(string $align): Grid
    {
        if (!in_array($align, ['left', 'right', 'between', 'center'])) {
            throw new RendererException("Grid align only supports 'left' | 'right' | 'between' | 'center'");
        }
        return $this->set('align', $align);
    }

    /**
     * 添加列
     * @param object|array $body
     * @return GridColumn
     */
    public function column(array|object $body): GridColumn
    {
        return tap((new GridColumn())->body($body), function ($value) {
            $this->columns->push($value);
        });
    }

    /**
     * 列集合
     * @param array|Collection $columns
     * @return Grid
     */
    public function columns($columns): Grid
    {
        if (is_array($columns)) {
            $columns = new Collection($columns);
        }
        return $this->set('columns', $columns);
    }
}