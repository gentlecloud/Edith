<?php
namespace Edith\Admin\Components\Amis\Table;

use Edith\Admin\Components\BaseRenderer;

/**
 * Amis Table 行单元格
 * @link https://baidu.github.io/amis/zh-CN/components/table-view
 * @method $this background(string $background)                        单元格背景色
 * @method $this color(string $color)                                  单元格文字颜色
 * @method $this bold(bool $bold)                                      单元格文字是否加粗  默认： false
 * @method $this width($width)                                         单元格宽度，只需要设置第一行
 * @method $this padding($padding)                                     单元格内间距
 * @method $this align(string $align)                                  单元格内的水平对齐，可以是 left、center、right 默认： left
 * @method $this valign(string $valign)                                单元格内的垂直对齐，可以是 top、middle、bottom、baseline 默认： middle
 * @method $this colspan(int $colspan)                                 单元格水平跨几行
 * @method $this rowspan(int $rowspan)                                 单元格垂直跨几列
 * @author Chico
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Td extends BaseRenderer {}