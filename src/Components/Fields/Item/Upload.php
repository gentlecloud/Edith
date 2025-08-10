<?php
namespace Edith\Admin\Components\Fields\Item;

use Edith\Admin\Components\Fields\Field;
use Edith\Admin\Components\Traits\Fields\UploadAttribute;


/**
 * Antd ProFormUploadButton
 * @link https://ant.design/components/upload-cn
 */
class Upload extends Field
{
    use UploadAttribute;

    /**
     * @var string
     */
    public string $component = 'upload';

    /**
     * @param string|null $name
     * @param string|null $label
     */
    public function __construct(?string $name = null, ?string $label = null)
    {
        parent::__construct($name, $label);
        $this->initAttribute();
        !is_null($label) && $this->title($label);
    }
}