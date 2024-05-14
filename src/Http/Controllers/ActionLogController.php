<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Components\Amis\Crud;
use Edith\Admin\Components\Amis\Form\InputDatetimeRange;
use Edith\Admin\Exceptions\RendererException;
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
    protected ?string $serviceName = "Edith\Admin\Services\ActionLogService";

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
        $crud->column('region', '属地')->copyable();
        $crud->column('created_at', '发生时间');

        $crud->operation()->rowOnlyDestroyAction();
        $crud->onlyBulkDeleteAction();

        $crud->filter([
            (new InputDatetimeRange('created_at', '发生时间'))
        ]);

        return $crud;
    }
}