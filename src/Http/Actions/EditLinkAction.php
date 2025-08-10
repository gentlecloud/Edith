<?php
namespace Edith\Admin\Http\Actions;

use Edith\Admin\Components\Actions\Action;
use Edith\Admin\Exceptions\RendererException;
use Illuminate\Support\Str;

class EditLinkAction extends Action
{
    /**
     * @var string
     */
    protected string $actionType = 'link';

    /**
     * @param string|null $label
     * @param string $type
     * @throws RendererException
     */
    public function __construct(?string $label = null, string $type = 'link')
    {
        parent::__construct($label ?? '编辑');
        $this->url((Str::replaceLast('/index', '', Str::replaceFirst('api/', '', \request()->path()))) . '/${id}');
        $this->size('small');
        $this->type = $type;
    }
}