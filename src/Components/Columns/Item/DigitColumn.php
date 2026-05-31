<?php
namespace Edith\Admin\Components\Columns\Item;

use Edith\Admin\Components\Columns\Column;
use Edith\Admin\Components\Traits\Fields\DigitAttribute;

/**
 * Antd Input-Number
 * @link https://ant-design.antgroup.com/components/input-number-cn
 */
class DigitColumn extends Column
{
    use DigitAttribute;

    /**
     * construct Digit Column
     * @param string|null $dataIndex
     * @param string|null $title
     */
    public function __construct(?string $dataIndex = null, ?string $title = null)
    {
        parent::__construct($dataIndex, $title, 'digit');
    }
}