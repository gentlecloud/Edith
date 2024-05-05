<?php
namespace Gentle\Edith\Components\Amis;

/**
 * Amis CollapseGroup
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/collapse
 * @method $this activeKey($activeKey)                初始化激活面板的key Array<string | number | never> | string | number>
 * @method $this expandIcon($expandIcon)              自定义切换图标
 * @method $this expandIconPosition(string $value)    设置图标位置，可选值left | right
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class CollapseGroup extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'collapse-group';

    /**
     * 手风琴模式
     * @default false
     * @param bool $accordion
     * @return CollapseGroup
     */
    public function accordion(bool $accordion = true): CollapseGroup
    {
        return $this->set('accordion', $accordion);
    }
}