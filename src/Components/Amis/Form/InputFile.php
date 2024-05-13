<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis Form InputFile 文件上传
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-file
 * @method $this receiver($receiver)                             上传文件接口 string | API
 * @method $this accept(string $accept)                          默认只支持纯文本，要支持其他类型，请配置此属性为文件后缀.xxx 默认： text/plain
 * @method $this maxSize(int $maxSize)                           默认没有限制，当设置后，文件大小大于此值将不允许上传。单位为B
 * @method $this maxLength(int $maxLength)                       默认没有限制，当设置后，一次只允许上传指定数量文件。
 * @method $this delimiter(string $delimiter)                    拼接符 默认： ','
 * @method $this stateTextMap(array $stateTextMap)               上传状态文案  { init: '', pending: '等待上传', uploading: '上传中', error: '上传出错', uploaded: '已上传', ready: '' }
 * @method $this fileField(string $fileField)                    如果你不想自己存储，则可以忽略此属性。 默认： 'file'
 * @method $this nameField(string $nameField)                    接口返回哪个字段用来标识文件名。 默认： 'name'
 * @method $this valueField(string $valueField)                  文件的值用那个字段来标识。 默认： 'value'
 * @method $this urlField(string $urlField)                      文件下载地址的字段名。 默认： 'url'
 * @method $this btnLabel(string $btnLabel)                      上传按钮的文字
 * @method $this downloadUrl($downloadUrl)                       默认显示文件路径的时候会支持直接下载，可以支持加前缀如：http://xx.dom/filename= ，如果不希望这样，可以把当前配置项设置为 false
 * @method $this useChunk($useChunk)                             amis 所在服务器，限制了文件上传大小不得超出 10M，所以 amis 在用户选择大文件的时候，自动会改成分块上传模式。
 * @method $this chunkSize(int $chunkSize)                       分块大小 默认 5 * 1024 * 1024
 * @method $this startChunkApi($startChunkApi)                   startChunkApi   string | API
 * @method $this chunkApi($chunkApi)                             chunkApi   string | API
 * @method $this finishChunkApi($finishChunkApi)                 finishChunkApi   string | API
 * @method $this concurrency(int $concurrency)                   分块上传时并行个数
 * @method $this documentation(string $documentation)            文档内容
 * @method $this documentLink(string $documentLink)              文档链接
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class InputFile extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-file';

    /**
     * construct
     * @param string|null $name
     * @param string|null $label
     */
    public function __construct(?string $name = null, ?string $label = null)
    {
        parent::__construct($name, $label);
        $this->receiver('api/attachments/upload');
    }

    /**
     * 将文件以base64的形式，赋值给当前组件
     * @default false
     * @param bool $asBase64
     * @return InputFile
     */
    public function asBase64(bool $asBase64 = true): InputFile
    {
        return $this->set('asBase64', $asBase64);
    }

    /**
     * 将文件以二进制的形式，赋值给当前组件
     * @default false
     * @param bool $asBlob
     * @return InputFile
     */
    public function asBlob(bool $asBlob = true): InputFile
    {
        return $this->set('asBlob', $asBlob);
    }

    /**
     * 是否多选
     * @default false
     * @param bool $multiple
     * @return InputFile
     */
    public function multiple(bool $multiple = true): InputFile
    {
        return $this->set('multiple', $multiple);
    }

    /**
     * 是否为拖拽上传
     * @default false
     * @param bool $drag
     * @return InputFile
     */
    public function drag(bool $drag = true): InputFile
    {
        return $this->set('drag', $drag);
    }

    /***
     * 拼接值
     * @default true
     * @param bool $joinValues
     * @return InputFile
     */
    public function joinValues(bool $joinValues = true): InputFile
    {
        return $this->set('joinValues', $joinValues);
    }

    /**
     * 提取值
     * @default false
     * @param bool $extractValue
     * @return InputFile
     */
    public function extractValue(bool $extractValue = true): InputFile
    {
        return $this->set('extractValue', $extractValue);
    }

    /**
     * 否选择完就自动开始上传
     * @default true
     * @param bool $autoUpload
     * @return InputFile
     */
    public function autoUpload(bool $autoUpload = true): InputFile
    {
        return $this->set('autoUpload', $autoUpload);
    }

    /**
     * 隐藏上传按钮
     * @default false
     * @param bool $hideUploadButton
     * @return InputFile
     */
    public function hideUploadButton(bool $hideUploadButton = true): InputFile
    {
        return $this->set('hideUploadButton', $hideUploadButton);
    }

    /**
     * 初表单反显时是否执行
     * @default true
     * @param bool $initAutoFill
     * @return InputFile
     */
    public function initAutoFill(bool $initAutoFill = true): InputFile
    {
        return $this->set('initAutoFill', $initAutoFill);
    }
}