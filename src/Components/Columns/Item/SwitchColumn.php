<?php
namespace Edith\Admin\Components\Columns\Item;

use Edith\Admin\Components\Columns\Column as BaseColumn;

class SwitchColumn extends BaseColumn
{

    /**
     * @param string|null $dataIndex
     * @param string|null $title
     */
    public function __construct(?string $dataIndex, ?string $title)
    {
        parent::__construct($dataIndex, $title, 'switch');
    }

    /**
     * @param bool $initialValue
     * @return self
     */
    public function initialValue(bool $initialValue): self
    {
        return parent::initialValue($initialValue);
    }

    /**
     * @param $value
     * @return self
     */
    public function defaultValue($value): self
    {
        return parent::defaultValue((bool) $value);
    }

    /**
     * @param string $text
     * @return $this
     */
    public function checkedChildren(string $text): self
    {
        $this->fieldProp('checkedChildren', $text);
        return $this;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function unCheckedChildren(string $text): self
    {
        $this->fieldProp('unCheckedChildren', $text);
        return $this;
    }

    /**
     * @param bool $value
     * @return self
     */
    public function defaultChecked(bool $value): self
    {
        return $this->fieldProp('defaultChecked', $value);
    }
}