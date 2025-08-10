<?php
namespace Edith\Admin\Components\Columns\Item;

use Edith\Admin\Components\Columns\Column;

class RadioColumn extends Column
{
    /**
     * @param string|null $dataIndex
     * @param string|null $title
     */
    public function __construct(?string $dataIndex = null, ?string $title = null)
    {
        parent::__construct($dataIndex, $title, 'radio');
    }

    /**
     * 指定当前是否选中
     * @param bool $value
     * @return self
     */
    public function checked(bool $value = true): self
    {
        return $this->fieldProp('checked', $value);
    }

    /**
     * 初始是否选中
     * @param bool $value
     * @return self
     */
    public function defaultChecked(bool $value = true): self
    {
        return $this->fieldProp('defaultChecked', $value);
    }
}