<?php
namespace Edith\Admin\Components\Amis\Action;

use Edith\Admin\Components\Amis\AmisRenderer;
use Edith\Admin\Exceptions\RendererException;
use Illuminate\Support\Collection;

/**
 * Action 行为按钮
 * Action 行为按钮，是触发页面行为的主要方法之一
 * 参考文档:    https://aisuda.bce.baidu.com/amis/zh-CN/components/action
 * @method $this label(string $label)                              按钮文本。可用 ${xxx} 取值。
 * @method $this icon(string $icon)                                设置图标，例如fa fa-plus。
 * @method $this iconClassName(string $iconClassName)              给图标上添加类名。
 * @method $this rightIcon(string $rightIcon)                      在按钮文本右侧设置图标，例如fa fa-plus。
 * @method $this rightIconClassName(string $rightIconClassName)    给右侧图标上添加类名。
 * @method $this activeLevel(string $activeLevel)                  按钮高亮时的样式，配置支持同level。
 * @method $this activeClassName(string $activeClassName)          给按钮高亮添加类名。默认： is-active
 * @method $this confirmText(string $confirmText)                  当设置后，操作在开始前会询问用户。可用 ${xxx} 取值。
 * @method $this reload(string $reload)                            指定此次操作完后，需要刷新的目标组件名字（组件的name值，自己配置的），多个请用 , 号隔开。
 * @method $this target(string $target)                            需要刷新的目标组件名字（组件的name值，自己配置的），多个请用 , 号隔开。
 * @method $this tooltip(string $tooltip)                          鼠标停留时弹出该段文字，也可以配置对象类型：字段为title和content。可用 ${xxx} 取值。
 * @method $this disabledTip(string $disabledTip)                  被禁用后鼠标停留时弹出该段文字，也可以配置对象类型：字段为title和content。可用 ${xxx} 取值。
 * @method $this close($close)                                     当action配置在dialog或drawer的actions中时，配置为true指定此次操作完后关闭当前dialog或drawer。当值为字符串，并且是祖先层弹框的名字的时候，会把祖先弹框关闭掉。
 * @method $this required(array $required)                         配置字符串数组，指定在form中进行操作之前，需要指定的字段名的表单项通过验证 string[]
 * @method $this url(string $url)                                  操作跳转链接
 * @method $this api(string $api)                                  后端 API 接口
 * @method $this content(string $content)                          复制文本。可用 ${xxx} 取值。
 * @method $this countDownTpl(string $tpl)                         倒计时模板。可用 ${timeLeft} 取值。
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Action extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'action';

    /**
     * 通过onEvent属性实现渲染器事件与响应动作的绑定。onEvent内配置事件和动作映射关系，actions是事件对应的响应动作的集合。
     * @var Collection
     */
    protected Collection $onEvent;

    /**
     * construct action
     * @param string|null $label 按钮文本。可用 ${xxx} 取值。
     */
    public function __construct(?string $label = null)
    {
        parent::__construct();
        $this->onEvent = new Collection();
        !is_null($label) && $this->set('label', $label);
    }

    /**
     * 这是 action 最核心的配置，来指定该 action 的作用类型 【必填】
     * @param string $actionType ajax | link | url | drawer | dialog | confirm | cancel | prev | next | copy | close | goBack | goPage | toast | custom
     * @param array|object|string|null $args
     * @return Action
     * @throws RendererException
     */
    public function actionType(string $actionType, $args = null): Action
    {
        if (in_array($actionType, ['toast', 'goBack', 'goPage', 'custom', 'refresh'])) {
            if ($this->onEvent->has('click')) {
                $click = $this->onEvent->get('click');
                if (isset($click['actions'])) {
                    $click['actions'][] = compact('actionType', 'args');
                } else {
                    $click['actions'] = [compact('actionType', 'args')];
                }
                $this->onEvent->put('click', $click);
            } else {
                $this->onEvent->put('click', [
                    'actions' => [compact('actionType', 'args')]
                ]);
            }
            return $this;
        } else {
            return $this->set('actionType', $actionType);
        }
    }

    /**
     * 按钮样式
     * @default default
     * @param string $level link | primary | secondary | info | success | warning | danger | light | dark | default
     * @return Action
     * @throws RendererException
     */
    public function level(string $level): Action
    {
        if (!in_array($level, ['link', 'primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light', 'dark', 'default'])) {
            throw new RendererException("Action Level only supports 'link', 'primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light', 'dark', 'default'");
        }
        return $this->set('level', $level);
    }

    /**
     * 设置按钮大小
     * @param string $size 'xs' | 'sm' | 'md' | 'lg'
     * @return Action
     * @throws \Exception
     */
    public function size(string $size): Action
    {
        if (!in_array($size, ['xs', 'sm', 'md', 'lg' ])) {
            throw new RendererException("Button size only supports 'xs' , 'sm', 'md', 'lg'");
        }
        return $this->set('size', $size);
    }

    /**
     * 按钮是否高亮。
     * @param bool $active
     * @return Action
     */
    public function active(bool $active = true): Action
    {
        return $this->set('active', $active);
    }

    /**
     * 用display:"block"来显示按钮。
     * @param bool $block
     * @return Action
     */
    public function block(bool $block = true): Action
    {
        return $this->set('block', $block);
    }

    /**
     * 气泡框位置器
     * @default top
     * @param string $tooltipPlacement 'top', 'right', 'bottom', 'left'
     * @return Action
     * @throws RendererException
     */
    public function tooltipPlacement(string $tooltipPlacement): Action
    {
        if (!in_array($tooltipPlacement, ['top', 'right', 'bottom', 'left' ])) {
            throw new RendererException("Button placement only supports 'top', 'right', 'bottom', 'left'");
        }
        return $this->set('tooltipPlacement', $tooltipPlacement);
    }

    /**
     * 触发 tootip
     * @param string $tooltipTrigger 'hover', 'focus'
     * @return Action
     * @throws RendererException
     */
    public function tooltipTrigger(string $tooltipTrigger): Action
    {
        if (!in_array($tooltipTrigger, ['hover', 'focus'])) {
            throw new RendererException("Button trigger only supports 'hover', 'focus'");
        }
        return $this->set('tooltipTrigger', $tooltipTrigger);
    }

    /**
     * Dialog 窗口
     * @param object $dialog
     * @return Action
     * @throws RendererException
     */
    public function dialog(object $dialog): Action
    {
        $this->actionType('dialog');
        return $this->set('dialog', $dialog);
    }

    /**
     * Drawer 窗口
     * @param object $drawer
     * @return Action
     * @throws RendererException
     */
    public function drawer(object $drawer): Action
    {
        $this->actionType('drawer');
        return $this->set('drawer', $drawer);
    }

    /**
     * @return Action
     * @throws RendererException
     */
    public function refresh(): Action
    {
        return $this->actionType('refresh');
    }

    /**
     * @param $event
     * @return $this
     */
    public function onEvent($event): Action
    {
        if ($this->onEvent->has('click')) {
            $click = $this->onEvent->get('click');
            if (isset($click['actions'])) {
                $click['actions'][] = $event;
            } else {
                $click['actions'] = [$event];
            }
            $this->onEvent->put('click', $click);
        } else {
            $this->onEvent->put('click', [
                'actions' => [$event]
            ]);
        }
        return $this;
    }

    /**
     * 发送验证码倒计时
     * @param int $seconds
     * @return Action
     */
    public function countDown(int $seconds): Action
    {
        $this->set('countDownTpl', '${timeLeft} 秒后重发');
        return $this->set('countDown', $seconds);
    }

    /**
     * @param string|array $click
     * @return $this
     */
    public function onClick(string|array $click): Action
    {
        if (is_string($click)) {
            $click = ['actionType' => 'custom', 'script' => $click];
        }
        return $this->onEvent($click);
    }

    /**
     * 自定义组件渲染
     * @return array
     * @throws RendererException
     */
    public function render(): array
    {
        if (!isset($this->actionType) && !$this->onEvent->has('click')) {
            throw new RendererException("Action ActionType cannot be empty");
        }
        return parent::render(); // TODO: Change the autogenerated stub
    }
}
