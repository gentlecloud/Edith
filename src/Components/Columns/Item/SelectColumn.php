<?php
namespace Edith\Admin\Components\Columns\Item;

use Edith\Admin\Components\Columns\Column as BaseColumn;
use Edith\Admin\Components\Traits\Fields\SelectAttribute;

class SelectColumn extends BaseColumn
{
    use SelectAttribute;

    /**
     * @param string|null $dataIndex
     * @param string|null $title
     */
    public function __construct(?string $dataIndex, ?string $title)
    {
        parent::__construct($dataIndex, $title, 'select');
    }


}