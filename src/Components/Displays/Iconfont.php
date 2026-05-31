<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;

/**
 * @method $this type(string $icon)
 * @method $this iconfontUrl(string $iconfontUrl)
 */
class Iconfont extends EngineRenderer
{
    /**
     * 翼搭 UI 渲染组件
     * @var string
     */
    public string $renderer = 'iconfont';

    /**
     * Ant Iconfont 图标
     * @var string
     */
    protected string $type = '';

    /**
     * @param string|null $type
     */
    public function __construct(?string $type = null)
    {
        parent::__construct();
        !is_null($type) && $this->set('type', $type);
    }
}