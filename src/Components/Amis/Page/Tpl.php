<?php
namespace Gentle\Edith\Components\Amis\Page;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Tpl 模板
 * 输出 模板 的常用组件
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/tpl
 * @method $this tpl(string $tpl)                            配置模板
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Tpl extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'tpl';

    /**
     * 是否设置外层 DOM 节点的 title 属性为文本内容
     * @param bool $showNativeTitle
     * @return Tpl
     */
    public function showNativeTitle(bool $showNativeTitle = true): Tpl
    {
        return $this->set('showNativeTitle', $showNativeTitle);
    }
}