<?php
namespace Gentle\Edith\Components\Amis;

use Gentle\Edith\Components\Amis\Action\Button;
use Gentle\Edith\Components\Amis\Action\Operation;
use Gentle\Edith\Components\Amis\Table\Column;
use Gentle\Edith\Components\Traits\CrudActions;
use Gentle\Edith\Exceptions\RendererException;
use Illuminate\Support\Collection;

/**
 * Amis CRUD 增删改查
 * CRUD，即增删改查组件，主要用来展现数据列表，并支持各类【增】【删】【改】【查】等操作。
 * @link https://aisuda.bce.baidu.com/amis/zh-CN/components/crud
 * @method $this title(string $title)                                                       可设置成空，当设置成空时，没有标题栏
 * @method $this api($api)                                                                  CRUD 用来获取列表数据的 api。 string | API
 * @method $this source(string $source)                                                     数据映射接口返回某字段的值，不设置会默认使用接口返回的${items}或者${rows}，也可以设置成上层数据源的内容
 * @method $this interval(int $interval)                                                    刷新时间(最低 1000) 默认 ： 3000
 * @method $this stopAutoRefreshWhen(string $stopAutoRefreshWhen)                           通过表达式来配置停止刷新的条件
 * @method $this messages(object $messages)                                                 覆盖消息提示，如果不指定，将采用 api 返回的 message
 * @method $this primaryField(string $primaryField)                                         设置 ID 字段名。 默认： id
 * @method $this perPage(int $perPage)                                                      设置一页显示多少条数据。 默认： 20
 * @method $this orderBy(string $orderBy)                                                   默认排序字段，这个是传给后端，需要后端接口实现
 * @method $this orderDir(string $orderDir)                                                 排序方向 asc | desc
 * @method $this defaultParams(object $defaultParams)                                       设置默认 filter 默认参数，会在查询的时候一起发给后端
 * @method $this pageField(string $pageField)                                               设置分页页码字段名。 默认： page
 * @method $this perPageField(string $perPageField)                                         设置分页一页显示的多少条数据的字段名。注意：最好与 defaultParams 一起使用，请看下面例子。。 默认： perPage
 * @method $this perPageAvailable(array $perPageAvailable)                                  设置一页显示多少条数据下拉框可选条数。 默认： [5, 10, 20, 50, 100]
 * @method $this orderField(string $orderField)                                             设置用来确定位置的字段名，设置后新的顺序将被赋值到该字段中。
 * @method $this labelTpl(string $labelTpl)                                                 单条描述模板，keepItemSelectionOnPageChange设置为true后会把所有已选择条目列出来，此选项可以用来定制条目展示文案。
 * @method $this autoFillHeight($autoFillHeight)                                            内容区域自适应高度 boolean 丨 {height: number}
 * @method $this prefixRow(array $prefixRow)                                                顶部总结行 参考： https://aisuda.bce.baidu.com/amis/zh-CN/components/table#%E6%80%BB%E7%BB%93%E8%A1%8C
 * @method $this affixRow(array $affixRow)                                                  底部总结行 参考： https://aisuda.bce.baidu.com/amis/zh-CN/components/table#%E6%80%BB%E7%BB%93%E8%A1%8C
 * @method $this itemCheckableOn(string $itemCheckableOn)
 * @author Chico
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Crud extends AmisRenderer
{
    use CrudActions;

    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'crud';

    /**
     * 模型主键 ID 字段名称
     * @default id
     * @var string
     */
    protected string $primaryField = 'id';

    /**
     * 一页显示多少条数据
     * @var int
     */
    protected int $perPage = 20;

    /**
     * 顶部工具栏配置
     * @var Collection
     */
    protected Collection $headerToolbar;

    /**
     * 底部工具栏配置
     * @var Collection
     */
    protected Collection $footerToolbar;

    /**
     * 批量操作按钮
     * @var Collection
     */
    protected Collection $bulkActions;

    /**
     * Crud 列信息
     * @var Collection
     */
    protected Collection $columns;

    /**
     * construct CRUD
     * @param string|null $title CRUD 标题
     * @param string|null $api CRUD 数据接口
     */
    public function __construct(?string $title = null, ?string $api = null)
    {
        parent::__construct();
        !is_null($title) && $this->set('title', $title);
        if (is_null($api))
        {
            $this->set('api', url()->current() . '?_action=datasource');
        } else {
            $this->set('api', $api);
        }
        $this->quickSaveApi();
        $this->columns = new Collection();
        $this->headerToolbar = new Collection();
        $this->bulkActions = new Collection();
        $this->footerToolbar = new Collection(['statistics', ['type' => 'pagination', 'align' => 'right'], ['type' => 'switch-per-page', 'align' => 'right']]);
    }

    /**
     * 显示模式 "table" 、 "cards" 或者 "list"  默认： table
     * @param string $mode 'table', 'cards', 'list'
     * @return Crud
     * @throws RendererException
     */
    public function mode(string $mode): Crud
    {
        if (!in_array($mode, ['table', 'cards', 'list'])) {
            throw new RendererException("Crud mode only supports 'table', 'cards' or 'list'");
        }
        return $this->set('mode', $mode);
    }

    /**
     * 是否一次性加载所有数据（前端分页）
     * @param bool $loadDataOnce
     * @return Crud
     */
    public function loadDataOnce(bool $loadDataOnce = true): Crud
    {
        return $this->set('loadDataOnce', $loadDataOnce);
    }

    /**
     * 在开启 loadDataOnce 时，filter 时是否去重新请求 api
     * @default true
     * @param bool $loadDataOnceFetchOnFilter
     * @return Crud
     */
    public function loadDataOnceFetchOnFilter(bool $loadDataOnceFetchOnFilter = true): Crud
    {
        return $this->set('loadDataOnceFetchOnFilter', $loadDataOnceFetchOnFilter);
    }

    /**
     * 设置过滤器，当该表单提交后，会把数据带给当前 mode 刷新列表。
     * @param array $controls 搜索表单列
     * @param string|null $title 搜索表单标题
     * @param array|null $actions 搜索操作按钮
     * @return Crud
     */
    public function filter(array $controls, ?string $title = null, ?array $actions = null): Crud
    {
        if (!is_array($actions)) {
            $actions = [
                (new Button('重置'))->actionType('clear-and-submit'),
                (new Button('搜索'))->level('primary')->actionType('submit'),
            ];
        }
        $filter = [
            'actions' => $actions,
            'body' => $controls,
            'title' => $title,
            'panelClassName' => 'filter-search'
        ];
        return $this->set('filter', $filter);
    }

    /**
     * 是否可显隐过滤器
     * @default false
     * @param bool $filterTogglable
     * @return Crud
     */
    public function filterTogglable(bool $filterTogglable = true): Crud
    {
        return $this->set('filterTogglable', $filterTogglable);
    }

    /**
     * 设置过滤器默认是否可见。
     * @default true
     * @param bool $filterDefaultVisible
     * @return Crud
     */
    public function filterDefaultVisible(bool $filterDefaultVisible = true): Crud
    {
        return $this->set('filterDefaultVisible', $filterDefaultVisible);
    }

    /**
     * 是否初始化的时候拉取数据, 只针对有 filter 的情况, 没有 filter 初始都会拉取数据
     * @default true
     * @param bool $initFetch
     * @return Crud
     */
    public function initFetch(bool $initFetch = true): Crud
    {
        return $this->set('initFetch', $initFetch);
    }

    /**
     * 配置刷新时是否隐藏加载动画
     * @default false
     * @param bool $silentPolling
     * @return Crud
     */
    public function silentPolling(bool $silentPolling = true): Crud
    {
        return $this->set('silentPolling', $silentPolling);
    }

    /**
     * 当有弹框时关闭自动刷新，关闭弹框又恢复
     * @default false
     * @param bool $stopAutoRefreshWhenModalIsOpen
     * @return Crud
     */
    public function stopAutoRefreshWhenModalIsOpen(bool $stopAutoRefreshWhenModalIsOpen = true): Crud
    {
        return $this->set('stopAutoRefreshWhenModalIsOpen', $stopAutoRefreshWhenModalIsOpen);
    }

    /**
     * 是否将过滤条件的参数同步到地址栏
     * @default true
     * @param bool $syncLocation
     * @return Crud
     */
    public function syncLocation(bool $syncLocation = true): Crud
    {
        return $this->set('syncLocation', $syncLocation);
    }

    /**
     * 是否可通过拖拽排序
     * @default false
     * @param bool $draggable
     * @return Crud
     */
    public function draggable(bool $draggable = true): Crud
    {
        $this->saveOrderApi();
        return $this->set('draggable', $draggable);
    }

    /**
     * 是否可以调整列宽度
     * @default true
     * @param bool $resizable
     * @return Crud
     */
    public function resizable(bool $resizable = true): Crud
    {
        return $this->set('resizable', $resizable);
    }

    /**
     * 用表达式来配置是否可拖拽排序
     * @param bool $itemDraggableOn
     * @return Crud
     */
    public function itemDraggableOn(bool $itemDraggableOn = true): Crud
    {
        return $this->set('itemDraggableOn', $itemDraggableOn);
    }

    /**
     * 隐藏顶部快速保存提示
     * @default false
     * @param bool $hideQuickSaveBtn
     * @return Crud
     */
    public function hideQuickSaveBtn(bool $hideQuickSaveBtn = true): Crud
    {
        return $this->set('hideQuickSaveBtn', $hideQuickSaveBtn);
    }

    /**
     * 当切分页的时候，是否自动跳顶部。
     * @default false
     * @param bool $autoJumpToTopOnPagerChange
     * @return Crud
     */
    public function autoJumpToTopOnPagerChange(bool $autoJumpToTopOnPagerChange = true): Crud
    {
        return $this->set('autoJumpToTopOnPagerChange', $autoJumpToTopOnPagerChange);
    }

    /**
     * 将返回数据同步到过滤器上。
     * @default true
     * @param bool $syncResponse2Query
     * @return Crud
     */
    public function syncResponse2Query(bool $syncResponse2Query = true): Crud
    {
        return $this->set('syncResponse2Query', $syncResponse2Query);
    }

    /**
     * 保留条目选择，默认分页、搜素后，用户选择条目会被清空，开启此选项后会保留用户选择，可以实现跨页面批量操作。
     * @default true
     * @param bool $keepItemSelectionOnPageChange
     * @return Crud
     */
    public function keepItemSelectionOnPageChange(bool $keepItemSelectionOnPageChange = true): Crud
    {
        return $this->set('keepItemSelectionOnPageChange', $keepItemSelectionOnPageChange);
    }

    /**
     * 是否总是显示分页
     * @default false
     * @param bool $alwaysShowPagination
     * @return Crud
     */
    public function alwaysShowPagination(bool $alwaysShowPagination = true): Crud
    {
        return $this->set('alwaysShowPagination', $alwaysShowPagination);
    }

    /**
     * 是否固定表头(table 下)
     * @default true
     * @param bool $affixHeader
     * @return Crud
     */
    public function affixHeader(bool $affixHeader = true): Crud
    {
        return $this->set('affixHeader', $affixHeader);
    }

    /**
     * 底部展示
     * @param bool $footable
     * @return Crud
     */
    public function footable(bool $footable = true): Crud
    {
        return $this->set('footable', $footable);
    }

    /**
     * 是否开启查询区域，开启后会根据列元素的 searchable 属性值，自动生成查询条件表单
     * @default false
     * @param int|bool $columnsNum 过滤条件单行列数 或为 true 时自动生成
     * @param bool $showBtnToolbar
     * @return Crud
     */
    public function autoGenerateFilter($columnsNum = true, bool $showBtnToolbar = false): Crud
    {
        if (is_bool($columnsNum)) {
            $autoGenerateFilter = true;
        } else {
            $autoGenerateFilter = [
                'columnsNum' => $columnsNum,
                'showBtnToolbar' => $showBtnToolbar
            ];
        }
        return $this->set('autoGenerateFilter', $autoGenerateFilter);
    }

    /**
     * 单条数据 ajax 操作后是否重置页码为第一页
     * @default false
     * @param bool $resetPageAfterAjaxItemAction
     * @return Crud
     */
    public function resetPageAfterAjaxItemAction(bool $resetPageAfterAjaxItemAction = true): Crud
    {
        return $this->set('resetPageAfterAjaxItemAction', $resetPageAfterAjaxItemAction);
    }

    /**
     * 设置列信息
     * @param array|Collection $columns
     * @return $this
     */
    public function columns(array|Collection $columns): Crud
    {
        if ($columns instanceof Collection) {
            $this->columns = $columns;
        } else {
            $this->columns = new Collection($columns);
        }
        return $this;
    }

    /**
     * 添加表格列
     * @param string|null $name 关联字段
     * @param string|null $label 表头
     * @return Column
     */
    public function column(?string $name = null, ?string $label = null): Column
    {
        return tap(new Column($name, $label), function ($value) {
            $this->columns->push($value);
        });
    }

    /**
     * @return $this
     */
    public function reload(): Crud
    {
        if (isset($this->headerToolbar)) {
            $this->headerToolbar->push('reload');
        } else {
            $this->set('headerToolbar', new Collection(['reload']));
        }
        return $this;
    }

    /**
     * @param array|Collection|null $buttons 操作按钮
     * @return Operation
     */
    public function operation(array|Collection|null $buttons = null): Operation
    {
        return tap(new Operation($buttons), function ($value) {
            $this->columns->push($value);
        });
    }

    /**
     * 保存排序的 api。
     * @param string|null $saveOrderApi
     * @return Crud
     */
    public function saveOrderApi(?string $saveOrderApi = null): Crud
    {
        if (is_null($saveOrderApi)) {
            $saveOrderApi = "put:" . url()->current() . '/saveOrder';
        }
        return $this->set('saveOrderApi', $saveOrderApi);
    }

    /**
     * 快速编辑后用来批量保存的 API。
     * @param string|null $quickSaveApi
     * @return Crud
     */
    public function quickSaveApi(?string $quickSaveApi = null): Crud
    {
        if (is_null($quickSaveApi)) {
            $quickSaveApi = "put:" . url()->current() . '/quickSave';
        }
        return $this->set('quickSaveApi', $quickSaveApi);
    }

    /**
     * 快速编辑配置成及时保存时使用的 API。
     * @param string|null $quickSaveItemApi
     * @return Crud
     */
    public function quickSaveItemApi(?string $quickSaveItemApi = null): Crud
    {
        if (is_null($quickSaveItemApi)) {
            $quickSaveItemApi = 'put:' . url()->current() . '/${' . ($this->primaryField ?: 'id') .'}';
        }
        return $this->set('quickSaveItemApi', $quickSaveItemApi);
    }

    /**
     * 顶部工具栏配置 默认： ['bulkActions', 'pagination']
     * @param array|Collection $headerToolbar
     * @return Crud
     */
    public function headerToolbars($headerToolbar): Crud
    {
        if (is_array($headerToolbar)) {
            $headerToolbar = new Collection($headerToolbar);
        }
        return $this->set('headerToolbar', $headerToolbar);
    }

    /**
     * @param $toolbar
     * @return $this
     */
    public function headerToolbar($toolbar): Crud
    {
        $this->headerToolbar->push($toolbar);
        return $this;
    }

    /**
     * 底部工具栏配置 默认： ['statistics', 'pagination']
     * @param array|Collection $footerToolbar
     * @return Crud
     */
    public function footerToolbar($footerToolbar): Crud
    {
        if (is_array($footerToolbar)) {
            $footerToolbar = new Collection($footerToolbar);
        }
        return $this->set('footerToolbar', $footerToolbar);
    }

    /**
     * 批量操作列表，配置后，表格可进行选中操作。
     * @param array|Collection $bulkActions
     * @return Crud
     */
    public function bulkActions(array|Collection $bulkActions): Crud
    {
        if (is_array($bulkActions)) {
            $bulkActions = new Collection($bulkActions);
        }
        return $this->set('bulkActions', $bulkActions);
    }

    /**
     * 渲染 Amis Json
     * @return array
     */
    public function render(): array
    {
        if ($this->headerToolbar->isEmpty()) {
            $this->headerToolbar = new Collection(['bulkActions', ['align' => 'right', 'type' => 'reload']]);
        }
        return parent::render(); // TODO: Change the autogenerated stub
    }
}