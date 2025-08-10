<?php
namespace Edith\Admin\Components\Traits\Attributes;

use Illuminate\Support\Collection;

trait ModalFormAttribute
{

    /**
     * @var Collection|null
     */
    protected ?Collection $modalProps;

    /**
     * @return void
     */
    public function initFormAttribute()
    {
        $this->modalProps = new Collection([
            'destroyOnHidden' => true
        ]);
    }

    /**
     * @param string $name
     * @param $value
     * @return $this
     */
    public function modalProp(string $name, $value): static
    {
        $this->modalProps->put($name, $value);
        return $this;
    }

    /**
     * @param array|Collection $props
     * @return $this
     */
    public function modalProps(array|Collection $props): static
    {
        if (is_array($props)) {
            $this->set('modalProps', new Collection($props));
        } else {
            $this->set('modalProps', $props);
        }
        return $this;
    }
}