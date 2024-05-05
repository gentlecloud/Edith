<?php
namespace Gentle\Edith\Components\Tabs;

use Gentle\Edith\Components\BaseRenderer;

/**
 * Ant Tab
 * @api https://ant.design/components/tabs-cn#Tabs.TabPane
 * @method $this closeIcon($closeIcon)                        自定义关闭图标，在 type="editable-card"时有效
 * @method $this key(string $key)                             对应 activeKey
 * @method $this label(string $label)                         选项卡头显示文字
 * @method $this children($children)                          选项卡头显示内容
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class TabPane extends BaseRenderer
{
    /**
     * construct TabPane
     * @param string|null $label 选项卡头显示文字
     * @param string|null $key 对应 activeKey
     */
    public function __construct(?string $label = null, ?string $key = null)
    {
        !is_null($label) && $this->set('label', $label);
        if (is_null($key)) {
            $key = uniqid('ant-tab-pane');
        }
        $this->set('key', $key);
    }

    /**
     * 禁用某一项
     * @default false
     * @param bool $disabled
     * @return TabPane
     */
    public function disabled(bool $disabled = true): TabPane
    {
        return $this->set('disabled', $disabled);
    }

    /**
     * 被隐藏时是否渲染 DOM 结构
     * @default false
     * @param bool $forceRender
     * @return TabPane
     */
    public function forceRender(bool $forceRender = true): TabPane
    {
        return $this->set('forceRender', $forceRender);
    }
}