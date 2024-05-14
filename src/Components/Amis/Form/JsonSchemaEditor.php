<?php
namespace Edith\Admin\Components\Amis\Form;

/**
 * Amis Form JSONSchema Editor
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/json-schema-editor
 * @method $this disabledTypes(array $disabledTypes)                        用来禁用默认数据类型，默认类型有：string、number、interger、object、number、array、boolean、null
 * @method $this definitions(array $definitions)                            用来配置预设类型
 * @method $this placeholder(array $placeholder)                            属性输入控件的占位提示文本  {key: "字段名", title: "名称", description: "描述", default: "默认值", empty: "<空>",}
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class JsonSchemaEditor extends FormItem
{

    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'json-schema-editor';

    /**
     * 顶级类型是否可配置
     * @default false
     * @param bool $rootTypeMutable
     * @return JsonSchemaEditor
     */
    public function rootTypeMutable(bool $rootTypeMutable = true): JsonSchemaEditor
    {
        return $this->set('rootTypeMutable', $rootTypeMutable);
    }

    /**
     * 是否显示顶级类型信息
     * @default false
     * @param bool $showRootInfo
     * @return JsonSchemaEditor
     */
    public function showRootInfo(bool $showRootInfo = true): JsonSchemaEditor
    {
        return $this->set('showRootInfo', $showRootInfo);
    }
}