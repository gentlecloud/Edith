<?php
namespace Edith\Admin\Components\Amis;

/**
 * Grid 2D 布局
 * Grid 2D 是一种二维布局方式，它可以更直观设置组件位置。 (Grid 2D 布局不支持 IE11)
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/grid-2d
 * @method Grid2D gridClassName(string $className)                   设置外层 Dom 的类名
 * @method Grid2D gap($gap)                                          格子间距，包括水平和垂直
 * @method Grid2D cols(int $cols)                                    格子水平划分为几个区域
 * @method Grid2D rowHeight(int $rowHeight)                          每个格子默认垂直高度
 * @method Grid2D rowGap($rowGap)                                    格子垂直间距
 * @method Grid2D grids(array $grids)                                 格子集合
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class Grid2D extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'grid-2d';
}