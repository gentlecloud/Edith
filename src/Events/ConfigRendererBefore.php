<?php
namespace Gentle\Edith\Events;

use Illuminate\Support\Collection;

class ConfigRendererBefore
{
    /**
     * @var Collection
     */
    public Collection $custom;

    /**
     * @var array
     */
    public array $initialValues = [];

    /**
     * construct
     */
    public function __construct()
    {
        $this->custom = new Collection();
    }
}
