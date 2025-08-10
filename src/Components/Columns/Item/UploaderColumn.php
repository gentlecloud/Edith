<?php
namespace Edith\Admin\Components\Columns\Item;

use Edith\Admin\Components\Columns\Column as BaseColumn;

/**
 * Edith 搭配 Antd 上传组件
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class UploaderColumn extends UploadColumn
{
    /**
     * @var string
     */
    public string $component = 'uploader';
}