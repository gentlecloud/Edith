<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Components\Tables\Table;
use Edith\Admin\Exceptions\RendererException;

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
    protected ?string $daoName = "Edith\Admin\Dao\ActionLogDao";

    /**
     * @param Table $table
     * @return Table
     * @throws RendererException
     */
    public function table(Table $table): Table
    {
        $table->column('id', '序号')->width(120)->sorter();
        $table->column('admin.nickname', '用户')->width(120)->sorter();
        $table->column('method', '请求方式')->width(80)->sorter()->showInSearch();
        $table->column('url', '行为链接')->copyable()->showInSearch();
        $table->column('ip', 'IP')->copyable()->sorter()->showInSearch();
        $table->column('region', '属地')->copyable();
        $table->column('created_at', '发生时间');
        $table->column('created_at', '创建时间')->valueType('dateRange')->hideInTable()->showInSearch()->placeholder(['起始创建时间', '截止创建时间']);

        $table->operation()->rowOnlyDestroyAction();
        return $table;
    }
}