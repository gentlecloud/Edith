<?php
namespace Edith\Admin\Components\Columns\Item;

use Edith\Admin\Components\Columns\Column;

class MoneyColumn extends Column
{
    /**
     * construct Money Column
     * @param string|null $dataIndex
     * @param string|null $title
     */
    public function __construct(?string $dataIndex = null, ?string $title = null)
    {
        parent::__construct($dataIndex, $title, 'money');
    }
}