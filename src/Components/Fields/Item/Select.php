<?php
namespace Edith\Admin\Components\Fields\Item;

use Edith\Admin\Components\Fields\Field;
use Edith\Admin\Components\Traits\Fields\SelectAttribute;

class Select extends Field
{
    use SelectAttribute;

    /**
     * @var string
     */
    public string $component = 'select';
}