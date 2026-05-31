<?php
namespace Edith\Admin\Components\Columns;

use Edith\Admin\Components\EngineRenderer;
use Illuminate\Support\Collection;

/**
 * @method $this title(string $title)
 */
class GroupColumn extends EngineRenderer
{
    /**
     * @var string
     */
    public string $renderer = 'column-group';

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
    public function __construct(?string $title = null)
    {
        parent::__construct();
        $this->columns = new Collection();
        !is_null($title) && $this->set('title', $title);
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

    /**+
     * @param bool $collapsible
     * @return self
     */
    public function collapsible(bool $collapsible = true): self
    {
        return $this->set('collapsible', $collapsible);
    }
}