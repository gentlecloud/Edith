<?php
namespace Edith\Admin\Components\Tables;

use Edith\Admin\Components\Layouts\Space;
use Edith\Admin\Components\Renderer;
use Edith\Admin\Exceptions\RendererException;
use Edith\Admin\Http\Actions\DeleteAction;
use Edith\Admin\Http\Actions\EditSchemaDrawerAction;
use Edith\Admin\Http\Actions\EditLinkAction;
use Edith\Admin\Http\Actions\EditSchemaModalAction;
use Illuminate\Support\Collection;


/**
 * @method $this width(string|int $value)                           行宽度
 */
class Operation extends Renderer
{
    /**
     * @var string
     */
    protected string $renderer = 'operation';

    /**
     * @var string 
     */
    protected string $title = "操作";

    /**
     * @var bool 
     */
    protected bool $search = false;

    /**
     * @var bool
     */
    protected bool $hideInForm = true;


    /**
     * @var bool
     */
    protected bool $hideInDescriptions = true;

    /**
     * @var Collection|Space
     */
    public Collection|Space $body;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->body = new Collection();
    }

    /**
     * 添加操作
     * @param array|object $action
     * @return $this
     */
    public function item(array|object $action): self
    {
        $this->body->push($action);
        return $this;
    }

    /**
     * @param array $actions
     * @return $this
     */
    public function items(array $actions): self
    {
        $this->body = new Collection($actions);
        return $this;
    }

    /**
     * 添加编辑和删除操作
     * @param array $fields
     * @param string|null $title
     * @param string $mode
     * @return $this
     * @throws RendererException
     */
    public function rowOnlyEditDestroyAction(array $fields = [], ?string $title = null, string $mode = 'drawer'): self
    {
        $this->addEditAction($fields, $title, $mode);
        $this->rowOnlyDestroyAction();
        return $this;
    }

    /**
     * 添加默认编辑按钮
     * @param array $fields
     * @param string|null $title
     * @param string $mode
     * @return $this
     * @throws RendererException
     */
    public function addEditAction(array $fields = [], ?string $title = null, string $mode = 'drawer'): self
    {
        switch ($mode) {
            case 'drawer':
                $this->body->push(new EditSchemaDrawerAction($title, $fields));
                break;
            case 'modal':
                $this->body->push(new EditSchemaModalAction($title, $fields));
                break;
            default:
                $this->body->push(new EditLinkAction($title ?? '编辑'));
                break;
        }
        return $this;
    }


    /**
     * 添加默认删除按钮
     * @return $this
     */
    public function rowOnlyDestroyAction(): self
    {
        $this->body->push(new DeleteAction());
        return $this;
    }
}