<?php
namespace Edith\Admin\Components\Columns\Item;

use Edith\Admin\Components\Columns\Column as BaseColumn;
use Edith\Admin\Components\Traits\Fields\TreeAttribute;

class TreeColumn extends BaseColumn
{
    use TreeAttribute;

    /**
     * @param string|null $dataIndex
     * @param string|null $title
     */
    public function __construct(?string $dataIndex, ?string $title)
    {
        parent::__construct($dataIndex, $title, 'tree');
    }

}