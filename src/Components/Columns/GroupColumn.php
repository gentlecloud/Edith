<?php
namespace Edith\Admin\Components\Columns;

use Edith\Admin\Components\EngineRenderer;
use Illuminate\Support\Collection;

class GroupColumn extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'column-group';

    /**
     * @var string
     */
    protected string $valueType = 'group';

    /**
     * 子列
     * @var Collection
     */
    protected Collection $columns;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->columns = new Collection();
    }

    /**
     * @param array $columns
     * @return $this
     */
    public function columns(array $columns): self
    {
        $this->columns = new Collection($columns);
        return $this;
    }
}