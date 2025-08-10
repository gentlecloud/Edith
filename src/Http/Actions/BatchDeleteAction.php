<?php
namespace Edith\Admin\Http\Actions;

use Edith\Admin\Components\Actions\Action;
use Edith\Admin\Exceptions\RendererException;

class BatchDeleteAction extends Action
{
    /**
     * @var string
     */
    protected string $actionType = 'ajax';

    /**
     * @param string|null $label
     * @param string|null $title
     * @param string $type
     * @throws RendererException
     */
    public function __construct(?string $label = null, ?string $title = null, string $type = 'link')
    {
        parent::__construct($label ?? '批量删除');
        $this->initApi('${ids}', 'delete')->danger();
        if (empty($title)) {
            $title = "是否确认要批量删除所选项";
        }
        $this->withConfirm($this->label, $title);
        $this->size('small');
        $this->type = $type;
    }
}