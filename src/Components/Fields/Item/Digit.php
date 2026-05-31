<?php
namespace Edith\Admin\Components\Fields\Item;

use Edith\Admin\Components\Fields\Field;
use Edith\Admin\Components\Traits\Fields\DigitAttribute;


/**
 * Antd Input-Number
 * @link https://ant-design.antgroup.com/components/input-number-cn
 */
class Digit extends Field
{
    use DigitAttribute;


    /**
     * @var string
     */
    public string $component = 'digit';

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