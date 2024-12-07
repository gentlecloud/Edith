<?php
namespace Edith\Admin\Components\Amis\Form;

use Edith\Admin\Exceptions\RendererException;

/**
 * Custom Form InputUploader 翼搭附件选择上传组件
 * 翼搭定制附件选择上传组件 支持选择已上传的图片/文件
 * @method $this action(string $action) 上传后端API
 * @method $this accept(string $accept) 上传文件类型
 */
class InputUploader extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-uploader';

    /**
     * 后端上传接口
     * @var string
     */
    protected string $action = '/api/attachments/upload';

    /**
     * @var bool
     */
    protected bool $multiple = false;

    /**
     * InputUploader constructor.
     * @param string|null $name
     * @param string|null $label
     */
    public function __construct(?string $name = null, ?string $label = null) {
        parent::__construct($name, $label);
    }

    /**
     * @param int $number
     * @return InputUploader
     */
    public function multiple(int $number = 1): InputUploader
    {
        $this->set('max', $number);
        return $this->set('multiple', $number > 1);
    }
}