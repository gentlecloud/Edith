<?php
namespace Edith\Admin\Components\Columns\Item;

use Edith\Admin\Components\Columns\Column;

class HiddenColumn extends Column
{
    /**
     * construct Hidden Column
     * @param string|null $dataIndex
     * @param string|null $title
     */
    public function __construct(?string $dataIndex = null, ?string $title = null)
    {
        parent::__construct($dataIndex, $title);
        $this->hidden();
    }
}