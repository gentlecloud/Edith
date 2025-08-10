<?php
namespace Edith\Admin\Components\Traits\Fields;

trait UploadAttribute
{

    /**
     * 初始化默认参数
     * @return $this
     */
    public function initAttribute(): static
    {
        // 上传文件数量
        $this->maxCount(1);
        // 上传文件大小，默认2M
        $this->fieldProp('limitSize', 2);
        $this->fieldProp('name', 'file');
        // 初始化上传接口
        $this->action('/api/attachments/upload');
        $this->listType('picture-card');
        $this->headers([
            'Authorization' => 'Bearer ${$edith.getToken()}'
        ]);
        return $this;
    }

    /**
     * 发到后台的文件参数名
     * @param string $name
     * @return $this
     */
    public function name(string $name): static
    {
        return $this->fieldProp('name', $name);
    }

    /**
     * FormItem label
     * @param string $title
     * @return $this
     */
    public function title(string $title): static
    {
        return $this->fieldProp('title', $title);
    }

    /**
     * Button 的标题
     * @param string $label
     * @return $this
     */
    public function button(string $label): static
    {
        return $this->fieldProp('button', $label);
    }

    /**
     * Button 的图标
     * @param string $icon
     * @return $this
     */
    public function icon(string $icon): static
    {
        return $this->fieldProp('icon', $icon);
    }

    /**
     * @param string $mode
     * @return $this
     */
    public function mode(string $mode): static
    {
        return $this->fieldProp('mode', $mode);
    }

    /**
     * 默认已经上传的文件列表
     * @param array $list
     * @return $this
     */
    public function defaultFileList(array $list): static
    {
        return $this->fieldProp('defaultFileList', $list);
    }

    /**
     * 点击打开文件对话框
     * @param bool $value
     * @return $this
     */
    public function openFileDialogOnClick(bool $value): static
    {
        return $this->fieldProp('openFileDialogOnClick', $value);
    }

    /**
     * 文件上传后端API
     * @param string $action
     * @return $this
     */
    public function action(string $action): static
    {
        return $this->fieldProp('action', $action);
    }

    /**
     * 接受上传的文件类型，详见 input accept Attribute
     * @param string $accept
     * @return $this
     */
    public function accept(string $accept): static
    {
        return $this->fieldProp('accept', $accept);
    }

    /**
     * 限制附件大小，单位：M
     * @param int $size
     * @return $this
     */
    public function limitSize(int $size): static
    {
        return $this->fieldProp('limitSize', $size);
    }

    /**
     * 支持上传文件夹
     * @param bool $directory
     * @return $this
     */
    public function directory(bool $directory = true): static
    {
        return $this->fieldProp('directory', $directory);
    }

    /**
     * 是否支持粘贴文件
     * @param bool $pastable
     * @return $this
     */
    public function pastable(bool $pastable = true): static
    {
        return $this->fieldProp('pastable', $pastable);
    }

    /**
     * 设置上传的请求头部，IE10 以上有效
     * @param array $headers
     * @return $this
     */
    public function headers(array $headers = []): static
    {
        return $this->fieldProp('headers', $headers);
    }

    /**
     * 上传请求的 http method
     * @param string $method
     * @return $this
     */
    public function method(string $method): static
    {
        return $this->fieldProp('method', $method);
    }

    /**
     * 限制上传数量。当为 1 时，始终用最新上传的文件代替当前文件
     * @param int $number
     * @return $this
     */
    public function maxCount(int $number = 1): static
    {
        $this->fieldProp('multiple', $number > 1);
        $this->fieldProp('maxCount', $number);
        $this->set('max', $number);
        return $this;
    }

    /**
     * 是否允许多选
     * @param bool $value
     * @return $this
     */
    public function multiple(bool $value = true): static
    {
        return $this->fieldProp('multiple', $value);
    }

    /**
     * 自定义进度条样式    ProgressProps（仅支持 type="line"）    { strokeWidth: 2, showInfo: false }
     * @param array $config
     * @return $this
     */
    public function progress(array $config): static
    {
        return $this->fieldProp('progress', $config);
    }

    /**
     * 是否展示文件列表, 可设为一个对象，用于单独设定 extra(5.20.0+), showPreviewIcon, showRemoveIcon, showDownloadIcon, removeIcon 和 downloadIcon    boolean | { extra?: ReactNode | (file: UploadFile) => ReactNode, showPreviewIcon?: boolean | (file: UploadFile) => boolean, showDownloadIcon?: boolean | (file: UploadFile) => boolean, showRemoveIcon?: boolean | (file: UploadFile) => boolean, previewIcon?: ReactNode | (file: UploadFile) => ReactNode, removeIcon?: ReactNode | (file: UploadFile) => ReactNode, downloadIcon?: ReactNode | (file: UploadFile) => ReactNode }
     * @param bool|array $value
     * @return $this
     */
    public function showUploadList(bool|array $value = true): static
    {
        return $this->fieldProp('showUploadList', $value);
    }

    /**
     * 上传请求时是否携带 cookie
     * @param bool $withCredentials
     * @return $this
     */
    public function withCredentials(bool $withCredentials = true): static
    {
        return $this->fieldProp('withCredentials', $withCredentials);
    }


    /**
     * 上传图片是否进行裁剪
     * @param bool $aspect
     * @return $this
     */
    public function aspect(bool $aspect = true): static
    {
        return $this->fieldProp('aspect', $aspect);
    }

    /**
     * 上传列表的内建样式，支持四种基本样式 text, picture, picture-card 和 picture-circle
     * @param string $type
     * @return $this
     */
    public function listType(string $type): static
    {
        return $this->fieldProp('listType', $type);
    }

    /**
     * 表单项渲染类型
     * @param string $valueType upload | file
     * @return $this
     */
    public function valueType(string $valueType): static
    {
        if ($valueType == 'file') {
            $this->title('上传文件');
        } else {
            $this->accept('image/*')->title('上传图片');
        }
        return $this->set('valueType', $valueType);
    }

    /**
     * @param string $id
     * @return $this
     */
    public function reload(string $id): static
    {
        return $this->set('reload', $id);
    }
}