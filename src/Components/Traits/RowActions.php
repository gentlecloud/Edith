<?php
namespace Edith\Admin\Components\Traits;

use Edith\Admin\Components\Amis\Action\Action;
use Edith\Admin\Components\Amis\Action\AjaxAction;
use Edith\Admin\Components\Amis\Action\Button;
use Edith\Admin\Components\Amis\Action\Dialog;
use Edith\Admin\Components\Amis\Action\Drawer;
use Edith\Admin\Components\Amis\Form\Form;
use Edith\Admin\Exceptions\RendererException;
use Illuminate\Support\Str;

trait RowActions
{
    /**
     * @param array|object $controls 表单字段
     * @param string $mode 窗口类型
     * @param string $type 按钮类型
     * @return $this
     * @throws RendererException
     */
    public function rowOnlyEditAction(array|object $controls = [], string $mode = 'modal', string $type = 'link')
    {
        $this->buttons->push($this->rowEditAction($controls, $mode, $type));
        return $this;
    }

    /**
     * @param string $type 按钮类型
     * @return $this
     * @throws RendererException
     */
    public function rowOnlyDestroyAction(string $type = 'link')
    {
        $this->buttons->push($this->rowDestroyAction($type));
        return $this;
    }

    /**
     * @param array|object $controls 表单字段
     * @param string $mode 窗口模式 modal | drawer | link
     * @param string $type 按钮类型 link、primary、secondary、info、success、warning、danger、light、dark、default
     * @return $this
     * @throws RendererException
     */
    public function rowOnlyEditDestroyAction(array|object $controls = [], string $mode = 'modal', string $type = 'link')
    {
        $this->buttons->push($this->rowEditAction($controls, $mode, $type));
        $this->buttons->push($this->rowDestroyAction($type));
        return $this;
    }

    /**
     * 基础行操作 详情, 编辑 , 删除
     * @param array|object $controls 表单字段
     * @param string $mode 窗口模式 modal | drawer | link
     * @param string $type 按钮类型 link、primary、secondary、info、success、warning、danger、light、dark、default
     * @return $this
     * @throws RendererException
     */
    public function rowBasicActions(array|object $controls = [], string $mode = 'modal', string $type = 'link')
    {
        $this->buttons->push($this->rowEditAction($controls, $mode, $type));
        $this->buttons->push($this->rowDestroyAction($type));
        return $this;
    }

    /**
     * @param array|object $controls 表单字段
     * @param string $mode 窗口模式 modal | drawer | link
     * @param string $type 按钮类型 link、primary、secondary、info、success、warning、danger、light、dark、default
     * @return object
     * @throws RendererException
     */
    protected function rowEditAction(array|object $controls = [], string $mode = 'modal', string $type = 'link')
    {
        if (is_object($controls) && !($controls instanceof Form)) {
            return $controls;
        }
        $action = (new Button)->label('编辑')->level($type);
        $url = \request()->route()->uri() . '/${id}/edit';
        if ($mode == 'link') {
            $component = $action->actionType('url')->url($url);
        } else {
            $api = \request()->route()->uri() . '/${id}';
            if ($controls instanceof Form) {
                $form = $controls;
            } else {
                $form = (new Form)->controls($controls);
            }
            $form->api("put:$api");
            switch ($mode) {
                case 'm':
                case 'modal':
                    $dialog = (new Dialog)->title('编辑')->size('lg')->body($form);
                    $component = $action->dialog($dialog);
                    break;
                case 'd':
                case 'drawer':
                    $drawer = (new Drawer)->title('编辑')->body($form)->size('lg');
                    $component = $action->drawer($drawer);
                    break;
                default:
                    throw new RendererException('表单仅支持 Modal, Drawer 或 Link', -5005);
            }
        }
        return $component;
    }

    /**
     * @param string $type link、primary、secondary、info、success、warning、danger、light、dark、default
     * @param string|null $api 后端处理接口
     * @return Action
     * @throws RendererException
     */
    protected function rowDestroyAction(string $type = 'link', ?string $api = null)
    {
        if (empty($api)) {
            $api = "delete:" . url()->current() . '/${id}';
        }
        return (new AjaxAction($api))->label('删除')->level($type)->confirmText('请确认是否要删除所选项？')->style(['color' => $type == 'link' ? '#FF5722' : '#FFFFFF']);
    }
}