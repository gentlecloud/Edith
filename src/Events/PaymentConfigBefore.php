<?php
namespace Gentle\Edith\Events;

use Illuminate\Support\Collection;

class PaymentConfigBefore
{
    /**
     * @var Collection
     */
    public Collection $payments;

    /**
     * construct
     */
    public function __construct() {
        $this->payments = new Collection();
    }

}
