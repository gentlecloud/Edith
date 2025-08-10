<?php
namespace Edith\Admin\Http\Actions;

use Edith\Admin\Components\Actions\Action;
use Edith\Admin\Exceptions\RendererException;

class BatchOpenAction extends Action
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
    public function __construct(?string $label = null, ?string $title = null, string $color = 'primary')
    {
        parent::__construct($label ?? '批量启用');
        $this->initApi('quickSave')->api([
            'api' => $this->api,
            'data' => [
                'ids' => '${ids}',
                'status' => 1
            ],
            'params' => [
                '_action' => 'quickSave'
            ]
        ]);
        if (empty($title)) {
            $title = "是否确认要批量启用所选项？";
        }
        $this->withConfirm($this->label, $title);
        $this->size('small');
        $this->set('color', $color);
        $this->variant('link');
    }
}