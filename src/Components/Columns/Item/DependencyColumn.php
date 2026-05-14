<?php
namespace Edith\Admin\Components\Columns\Item;

use Edith\Admin\Components\Columns\Column as BaseColumn;
use Illuminate\Support\Collection;

/**
 * Dependency
 */
class DependencyColumn extends BaseColumn
{
    /**
     * @var Collection
     */
    protected Collection $name;

    /**
     * @var Collection
     */
    protected Collection $condition;

    /**
     * @param string|null $dataIndex
     * @param string|null $title
     */
    public function __construct(?string $dataIndex = null, ?string $title = null)
    {
        parent::__construct($dataIndex, $title, 'dependency');
        $this->name = new Collection();
        $this->condition = new Collection();
    }

    /**
     * @param string $name
     * @param array|string|null|bool $condition
     * @return self
     */
    public function name(string $name, array|string|bool|null $condition = null): self
    {
        if (!is_null($condition)) {
            $this->condition->put($name, $condition);
        }
        $this->name->push($name);
        return $this;
    }

    /**
     * @param array|string $condition
     * @return self
     */
    public function condition(array|string $condition): self
    {
        if (is_string($condition)) {
            $condition = [$condition];
        }
        return $this->set('condition', new Collection($condition));
    }

    /**
     * @param array $columns
     * @return self
     */
    public function columns(array $columns): self
    {
        return $this->set('columns', $columns);
    }
}