<?php
namespace Edith\Admin\Http\Actions;

use Edith\Admin\Components\Forms\SchemaModalForm;
use Illuminate\Support\Str;

class CreateSchemaModalAction extends SchemaModalForm
{
    /**
     * @param string|null $title
     * @param array|null $fields
     * @param string|null $label
     * @param string $type
     */
    public function __construct(?string $title = null, ?array $fields = null, ?string $label = null, string $type = 'primary')
    {
        parent::__construct($label ?? ($title ?? '添加'));
        $this->initSaveApi();
        $this->title($title ?? $this->label);
        if ($fields) {
            $this->columns($fields);
        }
        isset($this->trigger) && $this->trigger->type($type)->size('xl')->icon('icon-plus-circle');
    }
}