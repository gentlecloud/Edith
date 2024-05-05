<?php
namespace Gentle\Edith\Components\Amis\Show;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Link 链接
 * 参考文档：  https://aisuda.bce.baidu.com/amis/zh-CN/components/link
 * @method $this href(string $href)                                   链接地址
 * @method $this htmlTarget(string $htmlTarget)                       a 标签的 target，优先于 blank 属性
 * @method $this title(string $title)                                 a 标签的 title
 * @method $this icon(string $icon)                                   超链接图标，以加强显示
 * @method $this rightIcon(string $rightIcon)                         右侧图标
 * @author Chico
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Link extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'link';

    /**
     * 是否在新标签页打开
     * @default false
     * @param bool $blank
     * @return Link
     */
    public function blank(bool $blank = true): Link
    {
        return $this->set('blank', $blank);
    }
}