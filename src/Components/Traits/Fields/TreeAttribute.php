<?php
namespace Edith\Admin\Components\Traits\Fields;

use Edith\Admin\Components\Displays\Iconfont;

/**
 * Antd Tree
 * @link https://ant-design.antgroup.com/components/tree-cn
 */
trait TreeAttribute
{

    /**
     * treeNodes 数据，如果设置则不需要手动构造 TreeNode 节点（key 在整个树范围内唯一）
     * @param array $value
     * @return $this
     */
    public function treeData(array $value): static
    {
        return $this->fieldProp('treeData', $value);
    }

    /**
     * 添加在 Tree 最外层的 style
     * @param array $value
     * @return $this
     */
    public function rootStyle(array $value): static
    {
        return $this->fieldProp('rootStyle', $value);
    }

    /**
     * 默认选中复选框的树节点
     * @param array $value
     * @return $this
     */
    public function defaultCheckedKeys(array $value): static
    {
        return $this->fieldProp('defaultCheckedKeys', $value);
    }

    /**
     * 默认展开指定的树节点
     * @param array $value
     * @return $this
     */
    public function defaultExpandedKeys(array $value): static
    {
        return $this->fieldProp('defaultExpandedKeys', $value);
    }

    /**
     * 默认选中的树节点
     * @param array $value
     * @return $this
     */
    public function defaultSelectedKeys(array $value): static
    {
        return $this->fieldProp('defaultSelectedKeys', $value);
    }

    /**
     * 自定义节点 title、key、children 的字段 { title: title, key: key, children: children }
     * @param array $value
     * @return $this
     */
    public function fieldNames(array $value): static
    {
        return $this->fieldProp('fieldNames', $value);
    }

    /**
     * 设置虚拟滚动容器高度，设置后内部节点不再支持横向滚动
     * @param int $value
     * @return $this
     */
    public function height(int $value): static
    {
        return $this->fieldProp('height', $value);
    }

    /**
     * 在标题之前插入自定义图标。需要设置 showIcon 为 true
     * @param string|Iconfont $value
     * @return $this
     */
    public function icon(string|Iconfont $value): static
    {
        return $this->fieldProp('icon', $value);
    }

    /**
     * 自定义树节点的展开/折叠图标（带有默认 rotate 角度样式）
     * @param string|Iconfont $value
     * @return $this
     */
    public function switcherIcon(string|Iconfont $value): static
    {
        return $this->fieldProp('switcherIcon', $value);
    }

    /**
     * 自定义树节点的加载图标
     * @param string|Iconfont $value
     * @return $this
     */
    public function switcherLoadingIcon(string|Iconfont $value): static
    {
        return $this->fieldProp('switcherLoadingIcon', $value);
    }

    /**
     * 是否允许拖拽时放置在该节点
     * @param bool $value
     * @return $this
     */
    public function allowDrop(bool $value = true): static
    {
        return $this->fieldProp('allowDrop', $value);
    }

    /**
     * 是否自动展开父节点
     * @param bool $value
     * @return $this
     */
    public function autoExpandParent(bool $value = true): static
    {
        return $this->fieldProp('autoExpandParent', $value);
    }

    /**
     * 是否节点占据一行
     * @param bool $value
     * @return $this
     */
    public function blockNode(bool $value = true): static
    {
        return $this->fieldProp('blockNode', $value);
    }

    /**
     * 节点前添加 Checkbox 复选框
     * @param bool $value
     * @return $this
     */
    public function checkable(bool $value = true): static
    {
        return $this->fieldProp('checkable', $value);
    }

    /**
     * checkable 状态下节点选择完全受控（父子节点选中状态不再关联）
     * @param bool $value
     * @return $this
     */
    public function checkStrictly(bool $value = true): static
    {
        return $this->fieldProp('checkStrictly', $value);
    }

    /**
     * 默认展开所有树节点
     * @param bool $value
     * @return $this
     */
    public function defaultExpandAll(bool $value = true): static
    {
        return $this->fieldProp('defaultExpandAll', $value);
    }

    /**
     * 默认展开父节点
     * @param bool $value
     * @return $this
     */
    public function defaultExpandParent(bool $value = true): static
    {
        return $this->fieldProp('defaultExpandParent', $value);
    }

    /**
     * 将树禁用
     * @param bool $value
     * @return $this
     */
    public function disabled(bool $value = true): static
    {
        return $this->fieldProp('disabled', $value);
    }

    /**
     * 设置节点可拖拽，可以通过 icon: false 关闭拖拽提示图标
     * @param bool|array $value
     * @return $this
     */
    public function draggable(bool|array $value = true): static
    {
        return $this->fieldProp('draggable', $value);
    }

    /**
     * 支持点选多个节点（节点本身）
     * @param bool $value
     * @return $this
     */
    public function multiple(bool $value = true): static
    {
        return $this->fieldProp('multiple', $value);
    }

    /**
     * 是否可选中
     * @param bool $value
     * @return $this
     */
    public function selectable(bool $value = true): static
    {
        return $this->fieldProp('selectable', $value);
    }

    /**
     * 控制是否展示 icon 节点，没有默认样式
     * @param bool $value
     * @return $this
     */
    public function showIcon(bool $value = true): static
    {
        return $this->fieldProp('showIcon', $value);
    }

    /**
     * 是否展示连接线
     * @param bool|array $value
     * @return $this
     */
    public function showLine(bool|array $value = true): static
    {
        return $this->fieldProp('showLine', $value);
    }

    /**
     * 设置 false 时关闭虚拟滚动
     * @param bool $value
     * @return $this
     */
    public function virtual(bool $value = true): static
    {
        return $this->fieldProp('virtual', $value);
    }
}