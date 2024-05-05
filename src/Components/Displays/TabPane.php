<?php
namespace Gentle\Edith\Components\Displays;

use Gentle\Edith\Components\Renderer;
use Illuminate\Support\Collection;

/**
 * Ant TabPane 标签页
 * @method $this label(string $label)                               选项卡头显示文字
 * @method $this key(string $key)                                   对应 activeKey
 * @method $this disabled(bool $disabled)                           禁用选项卡
 * @method $this forceRender(bool $forceRender)                     被隐藏时是否渲染 DOM 结构  默认： false
 * @method $this closeIcon(string $closeIcon)                       自定义关闭图标，在 type="editable-card"时有效
 * @method $this children($body)                                    选项卡头显示内容
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class TabPane extends Renderer
{
    /**
     * 翼搭渲染类型
     * @var string
     */
    protected string $type = 'ant-tab-pane';

    /**
     * construct ant tabPane
     * @param string|null $key 对应 activeKey
     * @param string|null $label 选项卡头显示文字
     */
    public function __construct(?string $key = null, ?string $label = null)
    {
        parent::__construct();
        !is_null($key) && $this->set('key', $key);
        !is_null($label) && $this->set('label', $label);
    }
}