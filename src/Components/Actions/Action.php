<?php
namespace Edith\Admin\Components\Actions;

use Edith\Admin\Components\EngineRenderer;
use Edith\Admin\Exceptions\RendererException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * 翼搭 Engine 引擎操作功能
 * @method $this actionType(string $actionType)                                 【必填】这是 action 最核心的配置，来指定该 action 的作用类型，支持：ajax、link、url、drawer、dialog、confirm、cancel、prev、next、copy、close。
 * @method $this href(string $url)                                               触发行为跳转链接
 * @method $this target(string $target)                                          链接的 target 属性，href 存在时生效
 * @method $this script(string $script)                                          自定义执行的js语句
 * @method $this label(string $label)                                            按钮 Label
 * @method $this icon(string $icon)                                              按钮 Icon
 * @method $this iconPosition(string $iconPosition)                              设置按钮图标组件的位置 start | end
 * @method $this tooltip(string $tooltip)                                        鼠标停留时弹出该段文字，也可以配置对象类型：字段为title和content。可用 ${xxx} 取值。
 * @method $this api(array|string $api)                                          后端API
 * @method $this htmlType(string $value)                                         设置 button 原生的 type 值，可选值请参考 HTML 标准	submit | reset | button
 * @method $this content(string $content)                                        复制文本，当actionType 为 copy 时必填
 * @method $this size(string $size)                                              设置按钮大小,large | middle | small | default
 * @method $this type(string $type)                                              设置按钮类型, primary | ghost | dashed | link | text | default
 * @method $this variant(string $variant)                                        设置按钮的变体 outlined | dashed | solid | filled | text | link
 * @method $this confirmTitle(string $confirmTitle)                              操作提示框标题
 * @method $this confirmText(string $confirmText)                                当设置后，操作在开始前会询问用户。可用 ${xxx} 取值。
 * @method $this confirmType(string $confirmType)                                当设置 confirmText 后，可设置提醒类型 如： pop confirm。
 * @method $this redirect(string $redirect)                                      Ajax 请求成功后跳转路径
 * @method $this visibleOn(string $visibleOn)                                    当添加满足时展示操作
 * @method $this disabledOn(string $disabledOn)                                  设置失效状态条件
 * @method $this carryData(array $data)                                          携带参数，将覆盖组件 Data 数据域
 * @method $this styles(array $styles)                                           自定义 Styles
 */
class Action extends EngineRenderer
{
    /**
     * @var string 
     */
    protected string $renderer = 'action';

    /**
     * 按钮大小,large | middle | small | default
     * @var string
     */
    protected string $size = 'default';

    /**
     * 设置按钮类型
     * @var string
     */
    protected string $type = 'default';

    /**
     * 通过onEvent属性实现渲染器事件与响应动作的绑定。onEvent内配置事件和动作映射关系，actions是事件对应的响应动作的集合。
     * @var Collection|null
     */
    protected ?Collection $onEvent;

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
     * @return $this
     */
    public function refresh(): self
    {
        return $this->actionType('refresh');
    }

    /**
     * 刷新组件 传入组件 scope_name
     * @param string $reloadName
     * @return $this
     */
    public function reload(string $reloadName): self
    {
        $this->set('reload', $reloadName);
        return $this->actionType('reload');
    }

    /**
     * 设置按钮的颜色  default | primary | danger | PresetColors
     * @param string $color
     * @return self
     * @throws RendererException
     */
    public function color(string $color): self
    {
        if (!in_array($color, ['default', 'primary', 'danger', 'blue' , 'purple', 'cyan', 'green', 'magenta', 'pink', 'red', 'orange', 'yellow', 'volcano', 'geekblue', 'lime', 'gold'])) {
            throw new RendererException("Button|Action Invalid color: $color");
        }
        return $this->set('color', $color);
    }

    /**
     * @param string|null $idField
     * @param string $method
     * @return $this
     */
    public function initApi(?string $idField = null, string $method = 'put'): self
    {
        if (!$idField || !Str::contains($idField, '/')) {
            $api = (Str::replaceLast('/index', '', Str::replaceFirst('api/', '', \request()->path())));
            if (!empty($idField)) {
                $api .= '/' . $idField;
            }
            return $this->set('api', "{$method}:{$api}");
        } else {
            return $this->set('api', "{$idField}");
        }
    }

    /**
     * 危险按钮
     * @param bool $danger
     * @return self
     */
    public function danger(bool $danger = true): self
    {
        return $this->set('danger', $danger);
    }

    /**
     * 设置按钮失效状态
     * @param bool $disabled
     * @return self
     */
    public function disabled(bool $disabled = true): self
    {
        return $this->set('disabled', $disabled);
    }

    /**
     * 幽灵属性，使按钮背景透明
     * @param bool $ghost
     * @return self
     */
    public function ghost(bool $ghost = true): self
    {
        return $this->set('ghost', $ghost);
    }

    public function modal(array|object $modal)
    {
        $this->actionType('modal');

        return $this;
    }

    public function drawer(array|object $drawer)
    {
        $this->actionType('drawer');

        return $this;
    }

    /**
     * @param string|null $title
     * @param string|null $text
     * @param string $type
     * @return $this
     * @throws RendererException
     */
    public function withConfirm(?string $title = null, ?string $text = null, string $type = 'confirm'): self
    {
        if (!in_array($type, ['confirm', 'pop'])) {
            throw new RendererException("Invalid action type: {$type}");
        }
        !empty($title) && $this->set('confirmTitle', $title);
        !empty($text) && $this->set('confirmText', $text);
        $this->set('confirmType', $type);
        return $this;
    }


    /**
     * 渲染 Scheme
     * @return array
     * @throws RendererException
     */
    public function render(): array
    {
        if (empty($this->actionType) && $this->renderer == 'action') {
            throw new RendererException('Action type is required.');
        }
        return parent::render();
    }
}