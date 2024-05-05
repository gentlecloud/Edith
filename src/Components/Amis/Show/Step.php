<?php
namespace Gentle\Edith\Components\Amis\Show;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Steps 步骤条 子步骤
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/steps#step
 * @method $this title(string $title)                    标题
 * @method $this subTitle(string $subTitle)              子标题
 * @method $this description(string $description)        详细描述
 * @method $this icon(string $icon)                      icon 名，支持 fontawesome v4 或使用 url
 * @method $this value(string $value)
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Step extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'step';

    /**
     * construct Steps step
     * @param string|null $title
     */
    public function __construct(?string $title = null)
    {
        parent::__construct();
        !is_null($title) && $this->set('title', $title);
    }
}