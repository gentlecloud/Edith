<?php
namespace Edith\Admin\Http\Actions;

use Edith\Admin\Components\Actions\Action;
use Edith\Admin\Exceptions\RendererException;

class BatchCloseAction extends Action
{
    /**
     * @var string
     */
    protected string $actionType = 'ajax';

    /**
     * @param string|null $label
     * @param string|null $title
     * @param string $color
     * @throws RendererException
     */
    public function __construct(?string $label = null, ?string $title = null, string $color = 'default')
    {
        parent::__construct($label ?? '批量禁用');
        $this->initApi('quickSave')->api([
            'api' => $this->api,
            'data' => [
                'ids' => '${ids}',
                'status' => 0
            ],
            'params' => [
                '_action' => 'quickSave'
            ]
        ]);
        if (empty($title)) {
            $title = "是否确认要批量禁用所选项？";
        }
        $this->withConfirm($this->label, $title);
        $this->size('small');
        $this->set('color', $color);
        $this->set('variant', 'link');
    }
}