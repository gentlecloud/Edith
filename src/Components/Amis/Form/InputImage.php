<?php
namespace Edith\Admin\Components\Amis\Form;

/**
 * Amis Form InputImage 图片
 * 图片格式输入，需要实现接收器，提交时将以 url 的方式提交，如果需要以表单方式提交请使用 InputFile。
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-image
 * @method $this receiver($receiver)                             上传文件接口 string | API
 * @method $this accept(string $accept)                          默认只支持纯文本，要支持其他类型，请配置此属性为文件后缀.jpg,.png 默认： .jpeg,.jpg,.png,.gif
 * @method $this maxSize(int $maxSize)                           默认没有限制，当设置后，文件大小大于此值将不允许上传。单位为B
 * @method $this maxLength(int $maxLength)                       默认没有限制，当设置后，一次只允许上传指定数量文件。
 * @method $this delimiter(string $delimiter)                    拼接符 默认： ','
 * @method $this fileField(string $fileField)                    如果你不想自己存储，则可以忽略此属性。 默认： 'file'
 * @method $this crop($crop)                                     用来设置是否支持裁剪。 boolean或{"aspectRatio":""}
 * @method $this cropFormat(string $cropFormat)                  裁剪文件格式 默认： image/png
 * @method $this cropQuality(int $cropQuality)                   裁剪文件格式的质量，用于 jpeg/webp，取值在 0 和 1 之间 默认: 1
 * @method $this limit(array $limit)                             限制图片大小，超出不让上传。
 * @method $this frameImage(string $frameImage)                  默认占位图地址
 * @method $this fixedSizeClassName(string $fixedSizeClassName)  开启固定尺寸时，根据此值控制展示尺寸。例如h-30,即图片框高为 h-30,AMIS 将自动缩放比率设置默认图所占位置的宽度，最终上传图片根据此尺寸对应缩放。
 * @author Chico, Xiamen Gentel Technology Co., Ltd
 */
class InputImage extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-image';

    /**
     * 是否多选
     * @default false
     * @param bool $multiple
     * @return InputImage
     */
    public function multiple(bool $multiple = true): InputImage
    {
        return $this->set('multiple', $multiple);
    }

    /***
     * 拼接值
     * @default true
     * @param bool $joinValues
     * @return InputImage
     */
    public function joinValues(bool $joinValues = true): InputImage
    {
        return $this->set('joinValues', $joinValues);
    }

    /**
     * 提取值
     * @default false
     * @param bool $extractValue
     * @return InputImage
     */
    public function extractValue(bool $extractValue = true): InputImage
    {
        return $this->set('extractValue', $extractValue);
    }

    /**
     * 否选择完就自动开始上传
     * @default true
     * @param bool $autoUpload
     * @return InputImage
     */
    public function autoUpload(bool $autoUpload = true): InputImage
    {
        return $this->set('autoUpload', $autoUpload);
    }

    /**
     * 隐藏上传按钮
     * @default false
     * @param bool $hideUploadButton
     * @return InputImage
     */
    public function hideUploadButton(bool $hideUploadButton = true): InputImage
    {
        return $this->set('hideUploadButton', $hideUploadButton);
    }

    /**
     * 是否开启固定尺寸,若开启，需同时设置 fixedSizeClassName
     * @param bool $fixedSize
     * @return InputImage
     */
    public function fixedSize(bool $fixedSize = true): InputImage
    {
        return $this->set('fixedSize', $fixedSize);
    }

    /**
     * 初表单反显时是否执行
     * @default true
     * @param bool $initAutoFill
     * @return $this
     */
    public function initAutoFill(bool $initAutoFill = true): InputImage
    {
        return $this->set('initAutoFill', $initAutoFill);
    }

    /**
     * 图片上传后是否进入裁剪模式
     * @default true
     * @param bool $dropCrop
     * @return InputImage
     */
    public function dropCrop(bool $dropCrop = true): InputImage
    {
        return $this->set('dropCrop', $dropCrop);
    }

    /**
     * 图片选择器初始化后是否立即进入裁剪模式
     * @default false
     * @param bool $initCrop
     * @return InputImage
     */
    public function initCrop(bool $initCrop = true): InputImage
    {
        return $this->set('initCrop', $initCrop);
    }
}