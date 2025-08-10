<?php
namespace Edith\Admin\Components\Fields\Item;

use Edith\Admin\Components\Fields\Field;
use Edith\Admin\Components\Traits\Fields\TreeAttribute;

class Tree extends Field
{
    use TreeAttribute;

    /**
     * @var string
     */
    public string $component = 'tree';
}