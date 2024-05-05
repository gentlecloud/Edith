<?php
namespace Gentle\Edith\Components\Amis\Show;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Icon 图标
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/icon
 * @method $this icon(string $icon)                        icon 名，支持 fontawesome v4 或使用 url
 * @method $this vendor(string $vendor)                    icon 类型，默认为fa, 表示 fontawesome v4。也支持 iconfont, 如果是 fontawesome v5 以上版本或者其他框架可以设置为空字符串
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Icon extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'icon';

    /**
     * construct Amis icon
     * @param string|null $icon icon 名，支持 fontawesome v4 或使用 url
     */
    public function __construct(?string $icon = null)
    {
        parent::__construct();
        !is_null($icon) && $this->set('icon', $icon);
    }
}