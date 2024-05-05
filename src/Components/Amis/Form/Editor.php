<?php
namespace Gentle\Edith\Components\Amis\Form;

use Gentle\Edith\Exceptions\RendererException;

/**
 * Amis Form Editor 编辑器
 * 用于实现代码编辑，如果要实现富文本编辑请使用 Rich-Text。
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/editor
 * @method $this language(string $language)                编辑器高亮的语言，支持通过 ${xxx} 变量获取
 * @method $this options(array $options)                   monaco 编辑器的其它配置，比如是否显示行号等，请参考这里，不过无法设置 readOnly，只读模式需要使用 disabled: true
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Editor extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string 
     */
    protected string $type = 'editor';

    /**
     * 编辑器高度
     * @default md
     * @param string $size md、lg、xl、xxl
     * @return Editor
     * @throws RendererException
     */
    public function size(string $size): Editor
    {
        if (!in_array($size, ['md', 'lg', 'xl', 'xxl'])) {
            throw new RendererException("Editor size only supports md、lg、xl、xxl");
        }
        return $this->set('size', $size);
    }

    /**
     * 是否显示全屏模式开关
     * @default false
     * @param bool $allowFullscreen
     * @return Editor
     */
    public function allowFullscreen(bool $allowFullscreen = true): Editor
    {
        return $this->set('allowFullscreen', $allowFullscreen);
    }
}