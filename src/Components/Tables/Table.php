<?php
namespace Edith\Admin\Components\Tables;

use Edith\Admin\Components\Displays\Dropdown;
use Edith\Admin\Components\EngineRenderer;
use Edith\Admin\Components\Layouts\Menu;
use Edith\Admin\Exceptions\RendererException;
use Edith\Admin\Http\Actions\BatchCloseAction;
use Edith\Admin\Http\Actions\BatchDeleteAction;
use Edith\Admin\Http\Actions\BatchOpenAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 *  Ant ProTable
 *  ProTable 的诞生是为了解决项目中需要写很多 table 的样板代码的问题，所以在其中封装了很多常用的逻辑。这些封装可以简单的分类为预设行为与预设逻辑。
 * @link https://procomponents.ant.design/components/table
 * @method $this rowKey(string $rowKey)                             数据主键
 * @method $this headerTitle(string|boolean $headerTitle)           顶部标题
 * @method $this tableLayout(string $tableLayout)                   表格元素的 table-layout 属性，设为 fixed 表示内容不会影响列的布局	- | auto | fixed
 * @method $this params(array $params)                              用于 request 查询的额外参数，一旦变化会触发重新加载
 * @method $this postData(array $postData)                          对通过 request 获取的数据进行处理
 * @method $this defaultData(array $defaultData)                    默认的数据
 * @method $this dataSource(array|string $dataSource)               Table 的数据，ProTable 推荐使用 request 来加载
 * @method $this toolBarRender(array $toolBarRender)                渲染工具栏，支持返回一个 dom 数组，会自动增加 margin-right
 * @method $this onRequestError(string $onRequestError)             数据加载失败时触发
 * @method $this tableClassName(string $tableClassName)             封装的 table 的 className
 * @method $this tableStyle(array $tableStyle)                      封装的 table 的 style	CSSProperties
 * @method $this options(array|bool $options)                       table 工具栏，设为 false 时不显示，传入 function 会点击时触发  { fullScreen: false, reload: true, density: true, setting: true }
 * @method $this defaultSize(string $defaultSize)                   默认的 size
 * @method $this type(string $defaultSize)                          pro-table 类型
 * @method $this dateFormatter(string $dateFormatter)               转化 moment 格式数据为特定类型，false 不做转化
 * @method $this beforeSearchSubmit(string $beforeSearchSubmit)     搜索之前进行一些修改	(
 * @method $this form(array $form)                                  antd form 的配置
 * @method $this columnEmptyText(string|boolean $columnEmptyText)   空值时的显示，不设置时显示 -， false 可以关闭此功能
 * @method $this manualRequest(boolean $manualRequest)              是否需要手动触发首次请求，配置为 true 时不可隐藏搜索表单 default: false
 * @method $this editable(array $editable)                          可编辑表格的相关配置
 * @method $this cardBordered(boolean|array $cardBordered)          Table 和 Search 外围 Card 组件的边框 boolean | {search?: boolean, table?: boolean}
 * @method $this ghost(boolean $ghost)                              幽灵模式，即是否取消表格区域的 padding default: false
 * @method $this debounceTime(int $debounceTime)                    防抖时间 default: 10
 * @method $this revalidateOnFocus(boolean $revalidateOnFocus)      窗口聚焦时自动重新请求
 * @method $this columnsState(array $columnsState)                  受控的列状态，可以操作显示隐藏
 * @method $this pagination(bool|array $pagination)                 分页配置
 * @method $this rowSelection(bool|array $rowSelection)             表格行是否可选择
 * @method $this scroll(array $scroll)                              表格是否可滚动，也可以指定滚动区域的宽、高，
 * @method $this sticky(array $sticky)                              设置粘性头部和滚动条
 * @method $this expandable(array|Table $expandable)                配置展开属性
 * @method $this striped(boolean $striped)                          行样式
 */
class Table extends EngineRenderer
{
    /**
     * 翼搭引擎渲染组件
     * @var string
     */
    public string $renderer = 'pro-table';

    /**
     * 获取 dataSource 的 API
     * @var string|null
     */
    protected ?string $api;

    /**
     * @var string
     */
    protected string $rowKey = 'id';

    /**
     * 默认的 size
     * @var string
     */
    protected string $defaultSize = 'default';

    /**
     * @var Collection
     */
    protected Collection $columns;

    /**
     * 分页配置
     * @var bool|array|int[]
     */
    protected bool|array $pagination = [
        'defaultPageSize' => 50
    ];

    /**
     * @var bool  
     */
    protected bool $striped = true;

    /**
     * 表格行是否可选择
     * @var array|bool
     */
    protected array|bool $rowSelection = true;

    /**
     * 行操作
     * @var Operation|null
     */
    protected ?Operation $operation = null;

    /**
     * @var Collection
     */
    protected Collection $batchActions;

    /**
     * 是否关闭批量删除
     * @var bool
     */
    protected bool $disableBatchDelete = false;

    /**
     * 是否关闭批量更新状态
     * @var bool
     */
    protected bool $disableBatchStatus = true;

    /**
     * 
     */
    public function __construct()
    {
        parent::__construct();
        $this->columns = new Collection();
        $this->batchActions = new Collection();
    }

    /**
     * 快速编辑后用来批量保存的 API。
     * @param string|null $api
     * @return $this
     */
    public function initApi(?string $api = null): Table
    {
        if (is_null($api)) {
            $api = (Str::replaceLast('/index', '', Str::replaceFirst('api/', '', \request()->path())));
        }
        return $this->set('api', $api);
    }

    /**
     * 快速编辑后用来批量保存的 API。
     * @param string|null $quickSaveApi
     * @return $this
     */
    public function initQuickSaveApi(?string $quickSaveApi = null): Table
    {
        if (is_null($quickSaveApi)) {
            $quickSaveApi = "put:" . (Str::replaceLast('/index', '', Str::replaceFirst('api/', '', \request()->path()))) . '/quickSave';
        }
        return $this->set('quickSaveApi', $quickSaveApi);
    }

    /**
     * 快速编辑配置成及时保存时使用的 API。
     * @param string|null $quickSaveItemApi
     * @return $this
     */
    public function initQuickSaveItemApi(?string $quickSaveItemApi = null): Table
    {
        if (is_null($quickSaveItemApi)) {
            $quickSaveItemApi = 'put:' . (Str::replaceLast('/index', '', Str::replaceFirst('api/', '', \request()->path()))) . '/${' . ($this->rowKey ?? 'id') .'}';
        }
        if (Str::contains($quickSaveItemApi, '_action')) {
            $quickSaveItemApi .= (Str::contains($quickSaveItemApi, '?') ? '&' : '?') . '_action=quickSave';
        }
        return $this->set('quickSaveItemApi', $quickSaveItemApi);
    }

    /**
     * @param \Closure|array $callback
     * @return $this
     */
    public function toolbar(\Closure|array $callback)
    {
        if (is_array($callback)) {
            $toolbar = (new Toolbar())->actions($callback);
        } else {
            $toolbar = new Toolbar();
            $callback($toolbar);
        }
        $this->set('toolbar', $toolbar);
        return $this;
    }

    /**
     *
     * @param \Closure|array|null $closure
     * @return Operation
     */
    public function operation(\Closure|array|null $closure = null): Operation
    {
        $this->operation = new Operation();
        if ($closure instanceof \Closure) {
            $closure($this->operation);
        } else if (is_array($closure)) {
            $this->operation->items($closure);
        }
        return $this->operation;
    }

    /**
     * 设置批量操作
     * @param array $batchActions
     * @return self
     */
    public function batchActions(array $batchActions = []): self
    {
        $this->batchActions = new Collection($batchActions);
        return $this;
    }

    /**
     * @param bool $virtual
     * @return self
     */
    public function virtual(bool $virtual = true): self
    {
        return $this->set('virtual', $virtual);
    }

    /**
     * @param bool $search
     * @return self
     */
    public function search(bool $search = false): self
    {
        return $this->set('search', $search);
    }

    /**
     * 关闭批量操作行
     * @param bool $disableBatchActions
     * @return $this
     */
    public function disableBatchActions(bool $disableBatchActions = true): self
    {
        $this->rowSelection = !$disableBatchActions;
        return $this;
    }

    /**
     * 关闭批量删除按钮
     * @param bool $disableBatchDelete
     * @return $this
     */
    public function disableBatchDelete(bool $disableBatchDelete = true): self
    {
        $this->disableBatchDelete = $disableBatchDelete;
        return $this;
    }

    /**
     * 关闭批量更新状态操作
     * @return $this
     */
    public function disableBatchStatus(): self
    {
        $this->disableBatchStatus = true;
        return $this;
    }

    /**
     * 开启批量更新状态操作
     * @return $this
     */
    public function enableBatchStatus(): self
    {
        $this->disableBatchStatus = false;
        return $this;
    }

    /**
     * @param int $pageSize
     * @return $this
     */
    public function pageSize(int $pageSize): Table
    {
        $this->pagination['defaultPageSize'] = $pageSize;
        return $this;
    }

    /**
     * 表格列
     * @param string $column
     * @param string|null $label
     * @return Column
     */
    public function column(string $column, string|null $label = ''): Column
    {
        $column = new Column($column, $label);

        return tap($column, function ($value) {
            $this->columns->push($value);
        });
    }

    /**
     * 批量添加列
     * @param array $columns
     * @return $this
     */
    public function columns(array $columns): self
    {
        $this->columns = $this->columns->merge($columns);
        return $this;
    }

    /**
     * @return array
     * @throws RendererException
     */
    public function render(): array
    {
        if ($this->operation instanceof Operation) {
            $this->columns->push($this->operation);
            unset($this->operation);
        }
        if (empty($this->api) && empty($this->dataSource)) {
            $this->initApi();
        }
        if ($this->rowSelection) {
            if (!$this->disableBatchStatus) {
                $dropdown = (new Dropdown('批量操作'))->menu(function (Menu $menu) {
                    $menu->items([
                        new BatchOpenAction(),
                        new BatchCloseAction(),
                    ]);
                })->arrow();
                $this->batchActions->push($dropdown);
            }
            if (!$this->disableBatchDelete) {
                $this->batchActions->push(new BatchDeleteAction);
            }
        }
        return parent::render();
    }
}