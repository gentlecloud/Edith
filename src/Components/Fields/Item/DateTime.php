<?php
namespace Edith\Admin\Components\Fields\Item;

use Edith\Admin\Components\Fields\Field;

class DateTime extends Field
{

    /**
     * @var string
     */
    public string $component = 'date-time-picker';

    /**
     * @param string|null $name
     * @param string|null $label
     */
    public function __construct(?string $name = null, ?string $label = null)
    {
        parent::__construct($name, $label);
        !is_null($label) && $this->title($label);
    }
}