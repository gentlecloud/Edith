<?php
namespace Edith\Admin\Components\Traits\Attributes;

use Illuminate\Support\Collection;

trait DrawerFormAttribute
{
    /**
     * @var Collection|null
     */
    protected ?Collection $drawerProps;

    /**
     * @return void
     */
    public function initFormAttribute()
    {
        $this->drawerProps = new Collection([
            'destroyOnHidden' => true
        ]);
    }

    /**
     * @param string $name
     * @param $value
     * @return $this
     */
    public function drawerProp(string $name, $value): static
    {
        $this->drawerProps->put($name, $value);
        return $this;
    }

    /**
     * @param array|Collection $props
     * @return $this
     */
    public function drawerProps(array|Collection $props): static
    {
        if (is_array($props)) {
            $this->set('drawerProps', new Collection($props));
        } else {
            $this->set('drawerProps', $props);
        }
        return $this;
    }
}