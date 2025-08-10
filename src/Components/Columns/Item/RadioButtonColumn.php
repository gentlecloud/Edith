<?php
namespace Edith\Admin\Components\Columns\Item;

class RadioButtonColumn extends RadioColumn
{
    /**
     * @param string|null $dataIndex
     * @param string|null $title
     */
    public function __construct(?string $dataIndex, ?string $title)
    {
        parent::__construct($dataIndex, $title);
        $this->valueType('radioButton');
    }
}