<?php
namespace Edith\Admin\Components\Columns\Item;

use Edith\Admin\Components\Columns\Column as BaseColumn;

class TreeSelectColumn extends BaseColumn
{
    /**
     * @param string|null $dataIndex
     * @param string|null $title
     */
    public function __construct(?string $dataIndex, ?string $title)
    {
        parent::__construct($dataIndex, $title, 'treeSelect');
    }

    /**
     * 默认打开子项
     * @param bool $expandAll
     * @return self
     */
    public function treeDefaultExpandAll(bool $expandAll = true): self
    {
        return $this->fieldProp('treeDefaultExpandAll', $expandAll);
    }
}