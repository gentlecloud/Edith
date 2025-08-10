<?php
namespace Edith\Admin\Components\Columns\Item;

use Edith\Admin\Components\Columns\Column as BaseColumn;
use Edith\Admin\Components\Traits\Fields\UploadAttribute;

/**
 * Edith 搭配 Antd 上传组件
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class UploadColumn extends BaseColumn
{
    use UploadAttribute;

    /**
     * @var string
     */
    public string $component = 'upload';

    /**
     * construct Uploader component
     * @param string|null $dataIndex
     * @param string|null $title
     */
    public function __construct(?string $dataIndex = null, ?string $title = null)
    {
        parent::__construct($dataIndex, $title, 'upload');
        $this->initAttribute();
        $this->title($title);
    }

    /**
     * @param string $component
     * @return self
     */
    public function component(string $component): self
    {
        return $this->set('component', $component);
    }
}