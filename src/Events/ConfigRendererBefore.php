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
     * construct
     */
    public function __construct()
    {
        $this->custom = new Collection();
    }
}
