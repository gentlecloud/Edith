<?php
namespace Edith\Admin\Components\Fields;

use Edith\Admin\Components\Forms\Column as FormColumn;

/**
 * Edith 搭配 Antd 上传组件
 * @method $this api(string $api)                       上传附件 API 接口
 * @method $this button(string $button)                 按钮名称，如：上传图片等
 * @method $this accept(string $limitType)              允许上传文件的类型
 * @method $this limitSize(int $limitSize)              上传文件大小，默认2M
 * @method $this limitNum(int $limitNum)                上传文件数量
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Uploader extends FormColumn
{
    /**
     * @var string
     */
    protected string $action = 'api/attachments/upload';

    /**
     * 图片上传模式，单图或多图，single|multiple
     * @var string
     */
    protected string $mode = 'single';

    /**
     * 上传文件大小，默认2M
     * @var int
     */
    protected int $limitSize = 2;

    /**
     * 上传文件数量
     * @var int
     */
    protected int $max = 1;

    /**
     * construct Uploader component
     * @param string|null $dataIndex
     * @param string|null $title
     */
    public function __construct(?string $dataIndex = null, ?string $title = null)
    {
        parent::__construct($dataIndex, $title);
    }

    /**
     * 上传图片是否进行裁剪
     * @param bool $aspect
     * @return Uploader
     */
    public function aspect(bool $aspect = true): Uploader
    {
        return $this->set('aspect', $aspect);
    }

    /**
     * 表单项渲染类型
     * @param string $valueType uploader | file
     * @return Uploader
     */
    public function valueType(string $valueType): Uploader
    {
        if ($valueType == 'file') {
            $this->button('上传文件');
        } else {
            $this->accept('image/*')->button('上传图片');
        }
        return parent::valueType($valueType);
    }
}