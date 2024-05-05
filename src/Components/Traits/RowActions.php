<?php
namespace Gentle\Edith\Components\Traits;

use Gentle\Edith\Components\Amis\Action\Action;
use Gentle\Edith\Components\Amis\Action\AjaxAction;
use Gentle\Edith\Components\Amis\Action\Dialog;
use Gentle\Edith\Components\Amis\Action\Drawer;
use Gentle\Edith\Components\Amis\Form\Form;
use Gentle\Edith\Exceptions\RendererException;
use Illuminate\Support\Str;

trait RowActions
{
    /**
     * @param string $type 按钮类型
     * @param string $mode 窗口类型
     * @return $this
     * @throws RendererException
     */
    public function rowOnlyEditAction(string $type = 'link', string $mode = 'link')
    {
        $this->buttons->push($this->rowEditAction($type, $mode));
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
     * @param string $type 按钮类型 link、primary、secondary、info、success、warning、danger、light、dark、default
     * @param string $mode 窗口模式 modal | drawer | link
     * @param array|null $fields 表单字段
     * @return $this
     * @throws RendererException
     */
    public function rowOnlyEditDestroyAction(string $type = 'link', string $mode = 'link', ?array $fields = [])
    {
        $this->buttons->push($this->rowEditAction($type, $mode, $fields));
        $this->buttons->push($this->rowDestroyAction($type));
        return $this;
    }

    /**
     * 基础行操作 详情, 编辑 , 删除
     * @param string $type 按钮类型 link、primary、secondary、info、success、warning、danger、light、dark、default
     * @param string $mode 窗口模式 modal | drawer | link
     * @param array|null $fields 表单字段
     * @return $this
     * @throws RendererException
     */
    public function rowBasicActions(string $type = 'link', string $mode = 'link', ?array $fields = [])
    {
        $this->buttons->push($this->rowEditAction($type, $mode, $fields));
        $this->buttons->push($this->rowDestroyAction($type));
        return $this;
    }

    /**
     * @param string $type 按钮类型 link、primary、secondary、info、success、warning、danger、light、dark、default
     * @param string $mode 窗口模式 modal | drawer | link
     * @param array|null $fields 表单字段
     * @return Action
     * @throws RendererException
     */
    protected function rowEditAction(string $type = 'link', string $mode = 'link', ?array $fields = [])
    {
        $action = (new Action)->label('编辑')->level($type);
        $prefix = Str::replaceFirst('api/', '', \request()->route()->getPrefix());
        $routeName = explode('.', \request()->route()->getName())[0];
        $url = "{$prefix}/{$routeName}" . '/${id}/edit';


        if ($mode == 'link') {
            $component = $action->actionType('url')->url($url);
        } else {
            $api = \request()->route()->getPrefix() . "/{$routeName}/" . '${id}';
            $form = (new Form())->api("put:$api")->controls($fields);
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