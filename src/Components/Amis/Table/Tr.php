<?php
namespace Gentle\Edith\Components\Amis\Table;

use Gentle\Edith\Components\BaseRenderer;
use Illuminate\Support\Collection;

/**
 * Amis 表格行
 * @link https://baidu.github.io/amis/zh-CN/components/table-view
 * @method $this height($height)                          表格行高
 * @method $this background(string $background)           行背景色
 * @author Chico
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Tr extends BaseRenderer {

    /**
     * 行单元格
     * @var Collection
     */
    protected Collection $tds;

    /**
     * construct tr
     */
    public function __construct()
    {
        $this->tds = new Collection();
    }

    /**
     * 行单元格
     * @param array|Collection $tds
     * @return $this
     */
    public function tds($tds): Tr
    {
        if ($tds instanceof Collection) {
            $this->tds = $tds;
        } else {
            $this->tds = new Collection($tds);
        }
        return $this;
    }

    /**
     * 添加单元格
     * @return Td
     */
    public function td(): Td
    {
        return tap(new Td, function ($value) {
            $this->tds->push($value);
        });
    }
}