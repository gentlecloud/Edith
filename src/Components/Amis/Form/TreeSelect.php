<?php
namespace Edith\Admin\Components\Amis\Form;

/**
 * Amis InputTree-Select
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-treet
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class TreeSelect extends InputTree
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'tree-select';

    /**
     * 是否隐藏选择框中已选择节点的路径 label 信息
     * @default false
     * @param bool $hideNodePathLabel
     * @return TreeSelect
     */
    public function hideNodePathLabel(bool $hideNodePathLabel = true): TreeSelect
    {
        return $this->set('hideNodePathLabel', $hideNodePathLabel);
    }

    /**
     * 只允许选择叶子节点
     * @default false
     * @param bool $onlyLeaf
     * @return TreeSelect
     */
    public function onlyLeaf(bool $onlyLeaf = true): TreeSelect
    {
        return $this->set('onlyLeaf', $onlyLeaf);
    }

    /**
     * 是否可检索，仅在 type 为 tree-select 的时候生效
     * @param bool $searchable
     * @default false
     * @return TreeSelect
     */
    public function searchable(bool $searchable = false): TreeSelect
    {
        return $this->set('searchable', $searchable);
    }
}