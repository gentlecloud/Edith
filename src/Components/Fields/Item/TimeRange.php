<?php
namespace Edith\Admin\Components\Fields\Item;

use Edith\Admin\Components\Fields\Field;

class TimeRange extends Field
{

    /**
     * @var string
     */
    public string $component = 'time-range';

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