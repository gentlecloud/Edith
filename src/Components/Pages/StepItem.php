<?php
namespace Edith\Admin\Components\Pages;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd StepItem
 * @method $this description(string $value)                             步骤的详情描述，可选
 * @method $this icon(string|array|object $value)                       步骤图标的类型，可选
 * @method $this status(string $value)                                  指定状态。当不配置该属性时，会使用 Steps 的 current 来自动指定状态。可选：wait process finish error
 * @method $this subTitle(string $value)                                子标题
 * @method $this title(string $value)                                   标题
 */
class StepItem extends EngineRenderer
{
    /**
     * @var string
     */
    public string $renderer = 'step-item';

    /**
     * @param string|null $title
     * @param string|null $status
     */
    public function __construct(?string $title = null, ?string $status = null)
    {
        parent::__construct();
        !is_null($title) && $this->set('title', $title);
        !is_null($status) && $this->set('status', $status);
    }

    /**
     * 禁用点击
     * @param bool $value
     * @return self
     */
    public function disabled(bool $value = true): self
    {
        return $this->set('disabled', $value);
    }
}