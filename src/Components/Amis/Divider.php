<?php
namespace Gentle\Edith\Components\Amis;

/**
 * Amis Divider 分割线
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/divider
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class Divider extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'divider';

    /**
     * 分割线的样式，支持 dashed和solid
     * @var string
     */
    protected string $lineStyle = 'dashed';

    /**
     * 分割线的样式
     * @param string $style dashed | solid
     * @return $this
     * @throws \Exception
     */
    public function lineStyle(string $style): Divider
    {
        if (!in_array($style, ['dashed', 'solid'])) {
            throw new \Exception("The style only supports' dashed ',' solid '");
        }
        $this->lineStyle = $style;
        return $this;
    }
}