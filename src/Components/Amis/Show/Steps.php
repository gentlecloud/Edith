<?php
namespace Edith\Admin\Components\Amis\Show;

use Edith\Admin\Components\Amis\AmisRenderer;
use Edith\Admin\Exceptions\RendererException;
use Illuminate\Support\Collection;

/**
 * Amis Steps 步骤条
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/steps
 * @method $this source($source)                   选项组源，可通过数据映射获取当前数据域变量、或者配置 API 对象 string | API
 * @method $this name(string $name)                关联上下文变量
 * @method $this value($value)                     设置默认值，注意不支持表达式
 * @method $this status($status)                   状态 	StepStatus | {[propName: string]: stepStatus;}  wait | process | finish | error
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Steps extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'steps';

    /**
     * 步骤信息
     * @var Collection
     */
    protected Collection $steps;

    /**
     * construct steps
     */
    public function __construct()
    {
        parent::__construct();
        $this->steps = new Collection();
    }

    /**
     * 指定步骤条方向。目前支持水平（horizontal）和竖直（vertical）两种方向
     * @param string $mode horizontal | vertical
     * @return Steps
     * @throws RendererException
     */
    public function mode(string $mode): Steps
    {
        if (!in_array($mode, ['horizontal', 'vertical'])) {
            throw new RendererException("Steps mode only supports horizontal or vertical");
        }
        return $this->set('mode', $mode);
    }

    /**
     * 指定步骤条方向。目前支持水平（horizontal）和竖直（vertical）两种方向
     * @param string $labelPlacement horizontal | vertical
     * @return Steps
     * @throws RendererException
     */
    public function labelPlacement(string $labelPlacement): Steps
    {
        if (!in_array($labelPlacement, ['horizontal', 'vertical'])) {
            throw new RendererException("Steps label-placement only supports horizontal or vertical");
        }
        return $this->set('labelPlacement', $labelPlacement);
    }

    /***
     * 点状步骤条
     * @default false
     * @param bool $progressDot
     * @return Steps
     */
    public function progressDot(bool $progressDot = true): Steps
    {
        return $this->set('progressDot', $progressDot);
    }

    /**
     * 配置步骤信息
     * @param array|Collection $steps
     * @return Steps
     */
    public function steps($steps): Steps
    {
        if (is_array($steps)) {
            $steps = new Collection($steps);
        }

        return $this->set('steps', $steps);
    }

    /**
     * @param string|null $title 步骤名称
     * @return Step
     */
    public function step(?string $title): Step
    {
        return tap(new Step($title), function ($value) {
            $this->steps->push($value);
        });
    }
}