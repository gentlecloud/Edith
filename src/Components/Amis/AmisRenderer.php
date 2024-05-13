<?php
namespace Gentle\Edith\Components\Amis;

use Gentle\Edith\Components\Renderer;

/**
 * @method $this data(array $data)                                页面携带变量
 * @method $this visibleOn(string $visibleOn)                     是否显示表达式
 * @method $this hiddenOn(string $hiddenOn)                       是否隐藏表达式
 * @method $this disabledOn(string $hiddenOn)                     是否禁用表达式
 * @method $this name(string $name)                               组件名称
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
abstract class AmisRenderer extends Renderer
{
    /**
     * 翼搭前端 UI 指定 Amis 渲染
     * @var string
     */
    protected string $renderer = "amis";

    /**
     * 是否显示
     * @param bool $visible
     * @return AmisRenderer
     */
    public function visible(bool $visible = true): AmisRenderer
    {
        return $this->set('visible', $visible);
    }

    /**
     * 是否隐藏
     * @param bool $hidden
     * @return AmisRenderer
     */
    public function hidden(bool $hidden = true): AmisRenderer
    {
        return $this->set('hidden', $hidden);
    }

    /**
     * @param bool $disabled
     * @return AmisRenderer
     */
    public function disabled(bool $disabled = true): AmisRenderer
    {
        return $this->set('disabled', $disabled);
    }
}