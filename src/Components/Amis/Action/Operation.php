<?php
namespace Edith\Admin\Components\Amis\Action;

use Closure;
use Edith\Admin\Components\Amis\AmisRenderer;
use Edith\Admin\Components\Traits\RowActions;
use Illuminate\Support\Collection;

/**
 * Amis Operation
 */
class Operation extends AmisRenderer
{
    use RowActions;

    /***
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'operation';

    /**
     * 操作栏 Label
     * @var string
     */
    protected string $label = '操作';

    /**
     * 操作按钮
     * @var Collection
     */
    protected Collection $buttons;

    /**
     * construct Operation
     */
    public function __construct(?array $buttons = null)
    {
        parent::__construct();
        if (is_null($buttons)) {
            $this->buttons = new Collection();
        } else {
            $this->buttons($buttons);
        }
    }

    /**
     * 批量添加操作按钮
     * @param array|Collection $buttons
     * @return $this
     */
    public function buttons($buttons): Operation
    {
        if ($buttons instanceof Collection) {
            $this->buttons = $buttons;
        } else {
            $this->buttons = new Collection($buttons);
        }
        return $this;
    }

    /**
     * 添加操作按钮
     * @param string $label 按钮名称
     * @return $this
     */
    public function button(string $label, Closure $callback = null): Operation
    {
        $button = new Button($label);
        if ($callback instanceof Closure) {
            $callback($button);
        }
        $this->buttons->push($button);
        return $this;
    }

    /**
     * @param array|object $action
     * @return $this
     */
    public function add($action)
    {
        $this->buttons->push($action);
        return $this;
    }
}