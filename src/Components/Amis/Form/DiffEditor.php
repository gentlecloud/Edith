<?php
namespace Edith\Admin\Components\Amis\Form;

/**
 * Amis Form DiffEditor 对比编辑器
 * 参考文档: https://aisuda.bce.baidu.com/amis/zh-CN/components/form/diff-editor
 * @method $this language(string $language)          编辑器高亮的语言，可选 支持的语言 默认： javascript
 * @method $this diffValue($diffValue)               左侧值
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class DiffEditor extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string 
     */
    protected string $type = 'diff-editor';
}