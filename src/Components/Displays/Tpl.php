<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;

/**
 * @method $this tpl(string $tpl)
 */
class Tpl extends EngineRenderer
{
    /**
     * 翼搭 UI 渲染组件
     * @var string
     */
    protected string $renderer = 'tpl';

    /**
     * @param string|null $tpl
     */
    public function __construct(?string $tpl = null)
    {
        parent::__construct();
        !is_null($tpl) && $this->set('tpl', $tpl);
    }
}