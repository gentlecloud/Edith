<?php
namespace Edith\Admin\Events;

use Illuminate\Support\Collection;

class ConfigRendererBefore
{
    /**
     * @var Collection
     */
    public Collection $custom;

    /**
     * @var Collection
     */
    public Collection $initialValues;

    /**
     * construct
     */
    public function __construct()
    {
        $this->custom = new Collection();
        $this->initialValues = new Collection();
    }
}
