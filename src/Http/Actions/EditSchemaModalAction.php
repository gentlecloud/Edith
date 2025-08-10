<?php
namespace Edith\Admin\Http\Actions;

use Edith\Admin\Components\Forms\SchemaModalForm;
use Illuminate\Support\Str;

class EditSchemaModalAction extends SchemaModalForm
{
    /**
     * @param string|null $title
     * @param array|null $fields
     * @param string|null $label
     * @param string $type
     */
    public function __construct(?string $title = null, ?array $fields = null, ?string $label = null, string $type = 'link')
    {
        parent::__construct($label ?? '编辑');
        $this->initSaveApi('${id}');
        $this->title('编辑' . $title);
        if ($fields) {
            $this->columns($fields);
        }
        isset($this->trigger) && $this->trigger->type($type);
    }
}