<?php
namespace Edith\Admin\Components\Amis\Form;

use Edith\Admin\Exceptions\RendererException;

/**
 * Amis Form InputRichText 富文本编辑器
 * 目前富文本编辑器基于两个库：froala 和 tinymce，默认使用 tinymce。
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-rich-text
 * @method $this receiver($receiver)               默认的图片保存 API string | API
 * @method $this videoReceiver($videoReceiver)     默认的视频保存 API
 * @method $this fileField(string $fileField)      上传文件时的字段名
 * @method $this options(array $options)           需要参考 tinymce 或 froala 的文档
 * @method $this buttons(array $buttons)           froala 专用，配置显示的按钮，tinymce 可以通过前面的 options 设置 toolbar 字符串
 */
class InputRichText extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-rich-text';
    
    /**
     * 默认图片上传保存地址
     * @var string
     */
    protected string $receiver = '/api/attachments/upload?return=tinymce';

    /**
     * 默认配置
     */
    protected array $options = [
        'convert_urls' => false
    ];

    /**
     * 框的大小
     * @param string $size md | lg
     * @return InputRichText
     * @throws RendererException
     */
    public function size(string $size): InputRichText
    {
        if (!in_array($size, ['md', 'lg'])) {
            throw new RendererException('Input rich text size only supports md or lg');
        }
        return $this->set('size', $size);
    }
}