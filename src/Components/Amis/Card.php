<?php
namespace Edith\Admin\Components\Amis;

/**
 * Amis Card 卡片
 * 官方文档 https://aisuda.bce.baidu.com/amis/zh-CN/components/card
 * @method $this href(string $url)                            	外部链接
 * @method $this header(array $header)                          Card 头部内容设置
 * @method $this bodyClassName(string $bodyClassName)           内容区域类名
 * @method $this actions(array $actions)                        配置按钮集合
 * @method $this actionsCount(int $actionsCount)                按钮集合每行个数
 * @method $this itemAction($itemAction)                        点击卡片的行为
 * @method $this media(array $media)                            Card 多媒体部内容设置
 * @method $this secondary($secondary)                          次要说明
 * @method $this toolbar(array $toolbar)                        工具栏按钮
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Card extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'card';

    /**
     * 是否显示拖拽图标
     * @default false
     * @param bool $dragging
     * @return Card
     */
    public function dragging(bool $dragging = true): Card
    {
        return $this->set('dragging', $dragging);
    }

    /**
     * 卡片是否可选
     * @default false
     * @param bool $selectable
     * @return Card
     */
    public function selectable(bool $selectable = true): Card
    {
        return $this->set('selectable', $selectable);
    }

    /**
     * 卡片选择按钮是否禁用
     * @default true
     * @param bool $checkable
     * @return Card
     */
    public function checkable(bool $checkable = true): Card
    {
        return $this->set('checkable', $checkable);
    }

    /**
     * 卡片选择按钮是否选中
     * @default false
     * @param bool $selected
     * @return Card
     */
    public function selected(bool $selected = true): Card
    {
        return $this->set('selected', $selected);
    }

    /**
     * 卡片选择按钮是否隐藏
     * @default false
     * @param bool $hideCheckToggler
     * @return Card
     */
    public function hideCheckToggler(bool $hideCheckToggler = true): Card
    {
        return $this->set('hideCheckToggler', $hideCheckToggler);
    }

    /**
     * 卡片是否为多选
     * @default false
     * @param bool $multiple
     * @return Card
     */
    public function multiple(bool $multiple = true): Card
    {
        return $this->set('multiple', $multiple);
    }

    /**
     * 卡片内容区的表单项 label 是否使用 Card 内部的样式
     * @default true
     * @param bool $useCardLabel
     * @return Card
     */
    public function useCardLabel(bool $useCardLabel = true): Card
    {
        return $this->set('useCardLabel', $useCardLabel);
    }
}