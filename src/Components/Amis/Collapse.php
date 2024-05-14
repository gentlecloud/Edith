<?php
namespace Edith\Admin\Components\Amis;

/**
 * Amis Collapse 折叠器
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/collapse
 * @method Collapse key($key)                                                      标识 string | number
 * @method Collapse header($header)                                                标题  string | SchemaNode
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Collapse extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'collapse';

    /**
     * 初始状态是否折叠
     * @param bool $collapsed
     * @return Collapse
     */
    public function collapsed(bool $collapsed = true): Collapse
    {
        return $this->set('collapsed', $collapsed);
    }

    /**
     * 是否展示图标
     * @default true
     * @param bool $showArrow
     * @return Collapse
     */
    public function showArrow(bool $showArrow = true): Collapse
    {
        return $this->set('showArrow', $showArrow);
    }
}