<?php
namespace Gentle\Edith\Components\Traits;

use Gentle\Edith\Components\Amis\Action\Action;
use Gentle\Edith\Components\Amis\Action\AjaxAction;
use Gentle\Edith\Components\Amis\Action\Dialog;
use Gentle\Edith\Components\Amis\Action\Drawer;
use Gentle\Edith\Components\Amis\Form\Form;
use Gentle\Edith\Exceptions\RendererException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait CrudActions
{
    /**
     * 创建基础 Toolbar 通过该行为操作将直接生成创建表单按钮，如需自定义，请使用 headerToolbar
     * @param array|object|string $mode 窗口类型
     * @param string $buttonName 按钮名称
     * @param array|null $fields 表单字段
     * @param string $type 按钮类型
     * @return $this
     * @throws RendererException
     */
    public function basicHeaderToolbar(array|object|string $mode = 'modal', string $buttonName = "创建", ?array $fields = [], string $type = 'primary')
    {
        $this->headerToolbars(new Collection([
            is_string($mode) ? $this->createAction($mode, $buttonName, $fields, $type) : $mode,
            'bulkActions',
            ['align' => 'right', 'type' => 'reload']
        ]));
        return $this;
    }

    /**
     * @param string $mode 窗口模式
     * @param string $buttonName 按钮名称
     * @param array|null $fields 表单字段
     * @param string $type 按钮类型
     * @return Action
     * @throws \Gentle\Edith\Exceptions\RendererException
     */
    public function createAction(string $mode = 'modal', string $buttonName = '创建', ?array $fields = [], string $type = 'primary'): Action
    {
        $action = (new Action)->level($type)->label($buttonName)->icon('fa-solid fa-plus');
        if ($mode == 'link') {
            $prefix = Str::replaceFirst('api/', '', \request()->route()->getPrefix());
            $routeName = explode('.', \request()->route()->getName())[0];

            $action->actionType('url')->url("{$prefix}/{$routeName}/create");
        } else {
            if (!is_array($fields)) {
                throw new RendererException('表单项应为 Array');
            }
            $api = "post:" . url()->current();
            $form = (new Form)->title($buttonName)->controls($fields)->api($api);
            switch ($mode) {
                case 'm':
                case 'modal':
                    $action->dialog((new Dialog)->size('lg')->title($buttonName)->body($form));
                    break;
                case 'd':
                case 'drawer':
                    $action->drawer((new Drawer)->size('lg')->title($buttonName)->body($form));
                    break;
                default:
                    throw new RendererException('表单仅支持 Modal, Drawer 或 Link', -5005);
            }
        }
        return $action;
    }

    /**
     * 生成批量删除按钮
     * @return $this
     * @throws RendererException
     */
    public function onlyBulkDeleteAction()
    {
        $api = "delete:" . url()->current() . '/${ids}';
        $this->bulkActions->push((new AjaxAction($api))
            ->label('删除')
            ->level('warning')
            ->icon('fa-solid fa-trash-can')
            ->confirmText('确认要删除当前所选项吗？'));
        return $this;
    }

    /**
     * 生成批量状态更新按钮
     * @return $this
     */
    public function onlyBulkStatusAction()
    {
        $open = (new AjaxAction([
            'url' => url()->current() . '/quickSave',
            'method' => 'PUT',
            'data' => ['status' => 1, 'ids' => '${ids|raw}']
        ]))->confirmText('确定要批量启用当前所选数据？')
            ->label('启用')
            ->icon('fa-solid fa-power-off');

        $close = (new AjaxAction([
            'url' => url()->current() . '/quickSave',
            'method' => 'PUT',
            'data' => ['status' => 0, 'ids' => '${ids|raw}']
        ]))->confirmText('确定要批量禁用当前所选数据？')
            ->label('禁用')
            ->icon('fa-solid fa-ban');

        $this->bulkActions->push($open);
        $this->bulkActions->push($close);
        return $this;
    }

    /**
     * 批量更新，删除按钮
     * @return $this
     * @throws RendererException
     */
    public function onlyBulkStatusDeleteAction()
    {
        $this->onlyBulkStatusAction();
        $this->onlyBulkDeleteAction();
        return $this;
    }
}