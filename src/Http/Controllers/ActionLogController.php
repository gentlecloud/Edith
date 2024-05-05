<?php
namespace Gentle\Edith\Http\Controllers;

use Gentle\Edith\Components\Amis\Crud;
use Gentle\Edith\Exceptions\RendererException;
use Illuminate\Http\Request;

class ActionLogController extends Controller
{
    /**
     * @var string|null
     */
    protected ?string $title = '操作日志';

    /**
     * 控制器服务层
     * @var string|null
     */
    protected ?string $serviceName = "Gentle\Edith\Services\ActionLogService";

    /**
     * @param Crud $crud
     * @return Crud
     * @throws RendererException
     */
    public function crud(Crud $crud): Crud
    {
        $crud->column('id', '序号')->width(120)->sortable();
        $crud->column('admin.username', '用户')->width(120)->sortable();
        $crud->column('method', '请求方式')->width(80)->sortable();
        $crud->column('url', '行为链接')->copyable();
        $crud->column('ip', 'IP')->copyable()->sortable();
        $crud->column('region', '定位')->copyable();
        $crud->column('created_at', '发生时间');

        $crud->operation()->rowOnlyDestroyAction();
        $crud->onlyBulkDeleteAction();

        return $crud;
    }
}