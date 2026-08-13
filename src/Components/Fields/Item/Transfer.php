<?php
namespace Edith\Admin\Components\Fields\Item;

use Edith\Admin\Components\Fields\Field;
use Edith\Admin\Components\Traits\Fields\TransferAttribute;

class Transfer extends Field
{
    use TransferAttribute;

    /**
     * @var string
     */
    public string $component = 'tinymce';
}