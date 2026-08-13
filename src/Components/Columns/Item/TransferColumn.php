<?php
declare(strict_types=1);

namespace Edith\Admin\Components\Columns\Item;

use Edith\Admin\Components\Tables\Column;
use Edith\Admin\Components\Traits\Fields\TransferAttribute;

/**
 * Antd Transfer
 * 穿梭框
 * @link https://ant.design/components/transfer-cn
 * 
 */
class TransferColumn extends Column
{

    use TransferAttribute;

    /**
     * @var string
     */
    protected string $valueType = 'transfer';

}