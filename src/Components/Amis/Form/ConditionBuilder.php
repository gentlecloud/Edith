<?php
namespace Edith\Admin\Components\Amis\Form;

use Edith\Admin\Exceptions\RendererException;

/**
 * Amis Form 组合条件
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/condition-builder
 * @method $this fieldClassName(string $fieldClassName)                          输入字段的类名
 * @method $this source($source)                                                 通过远程拉取配置项
 * @method $this fields($fields)                                                 字段配置
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class ConditionBuilder extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'condition-builder';

    /**
     * 内嵌展示
     * @default true
     * @param bool $embed
     * @return ConditionBuilder
     */
    public function embed(bool $embed = true): ConditionBuilder
    {
        return $this->set('embed', $embed);
    }

    /**
     * 用于 simple 模式下显示切换按钮
     * @param bool $showANDOR
     * @return ConditionBuilder
     */
    public function showANDOR(bool $showANDOR = true): ConditionBuilder
    {
        return $this->set('showANDOR', $showANDOR);
    }

    /**
     * 是否显示「非」按钮
     * @param bool $showNot
     * @return ConditionBuilder
     */
    public function showNot(bool $showNot = true): ConditionBuilder
    {
        return $this->set('showNot', $showNot);
    }

    /**
     * 字段是否可搜索
     * @param bool $searchable
     * @return ConditionBuilder
     */
    public function searchable(bool $searchable = true): ConditionBuilder
    {
        return $this->set('searchable', $searchable);
    }

    /**
     * 组合条件左侧选项类型
     * @param string $selectMode
     * @return ConditionBuilder
     * @throws RendererException
     */
    public function selectMode(string $selectMode): ConditionBuilder
    {
        if (!in_array($selectMode, ['list', 'tree'])) {
            throw new RendererException("Select mode only supports 'list'、'tree'");
        }
        return $this->set('selectMode', $selectMode);
    }
}