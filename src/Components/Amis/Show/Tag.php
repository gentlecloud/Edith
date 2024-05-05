<?php
namespace Gentle\Edith\Components\Amis\Show;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Tag 标签
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/tag
 * @method $this label(string $label)                 标签内容
 * @method $this icon(string $icon)                   status 模式下的前置图标
 * @method $this color(string $color)                 颜色主题，提供默认主题，并支持自定义颜色值  'active' | 'inactive' | 'error' | 'success' | 'processing' | 'warning' | 具体色值
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Tag extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'tag';

    /**
     * 展现模式 默认： normal
     * @param string $displayMode 'normal' | 'rounded' | 'status'
     * @return Tag
     * @throws \Exception
     */
    public function displayMode(string $displayMode): Tag
    {
        if (!in_array($displayMode, ['normal', 'rounded', 'status'])) {
            throw new \Exception("displayMode only supports 'normal' | 'rounded' | 'status'");
        }
        return $this->set('displayMode', $displayMode);
    }
}