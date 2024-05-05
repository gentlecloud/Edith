<?php
namespace Gentle\Edith\Components\Amis\Form;

use Gentle\Edith\Exceptions\RendererException;

/**
 * Amis Transfer 穿梭器
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/transfer
 * @method $this options(array $options)                        选项组  Array<object>或Array<string>
 * @method $this source($source)                                动态选项组 string | API
 * @method $this delimeter(string $delimeter)                   拼接符
 * @method $this searchApi(string $searchApi)                   如果想通过接口检索，可以设置这个 api。 string | API
 * @method $this selectTitle(string $selectTitle)               左侧的标题文字 默认： "请选择"
 * @method $this resultTitle(string $resultTitle)               右侧结果的标题文字 默认： "当前选择"
 * @method $this searchResultMode(string $searchResultMode)     如果不设置将采用 selectMode 的值，可以单独配置，参考 selectMode，决定搜索结果的展示形式。
 * @method $this searchPlaceholder(string $searchPlaceholder)   左侧列表搜索框提示
 * @method $this columns(array $columns)                        当展示形式为 table 可以用来配置展示哪些列，跟 table 中的 columns 配置相似，只是只有展示功能。  Array<Object>
 * @method $this leftOptions(array $leftOptions)                当展示形式为 associated 时用来配置左边的选项集。  Array<Object>
 * @method $this leftMode(string $leftMode)                     当展示形式为 associated 时用来配置左边的选择形式，支持 list 或者 tree。默认为 list。
 * @method $this rightMode(string $rightMode)                   当展示形式为 associated 时用来配置右边的选择形式，可选：list、table、tree、chained。
 * @method $this resultSearchPlaceholder(string $value)         右侧列表搜索框提示
 * @method $this menuTpl($menuTpl)                              用来自定义选项展示  string | SchemaNode
 * @method $this valueTpl($valueTpl)                            用来自定义值的展示  string | SchemaNode
 * @method $this itemHeight(int $itemHeight)                    每个选项的高度，用于虚拟渲染 默认： 32
 * @method $this virtualThreshold(int $virtualThreshold)        在选项数量超过多少时开启虚拟渲染 默认： 100
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Transfer extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'transfer';

    /**
     * 拼接值
     * @default true
     * @param bool $joinValues
     * @return Transfer
     */
    public function joinValues(bool $joinValues = true): Transfer
    {
        return $this->set('joinValues', $joinValues);
    }

    /**
     * 提取值
     * @default false
     * @param bool $extractValue
     * @return Transfer
     */
    public function extractValue(bool $extractValue = true): Transfer
    {
        return $this->set('extractValue', $extractValue);
    }

    /**
     * 结果面板跟随模式，目前只支持list、table、tree（tree 目前只支持非延时加载的tree）
     * @default false
     * @param bool $resultListModeFollowSelect
     * @return Transfer
     */
    public function resultListModeFollowSelect(bool $resultListModeFollowSelect = true): Transfer
    {
        return $this->set('resultListModeFollowSelect', $resultListModeFollowSelect);
    }

    /**
     * 是否显示统计数据
     * @default true
     * @param bool $statistics
     * @return Transfer
     */
    public function statistics(bool $statistics = true): Transfer
    {
        return $this->set('statistics', $statistics);
    }

    /**
     * 结果可以进行拖拽排序（结果列表为树时，不支持排序）
     * @default false
     * @param bool $sortable
     * @return Transfer
     */
    public function sortable(bool $sortable = true): Transfer
    {
        return $this->set('sortable', $sortable);
    }

    /**
     * 分别为：列表形式、表格形式、树形选择形式、级联选择形式，关联选择形式（与级联选择的区别在于，级联是无限极，而关联只有一级，关联左边可以是个 tree）。
     * @param string $selectMode list、table、tree、chained、associated
     * @return Transfer
     * @throws RendererException
     */
    public function selectMode(string $selectMode): Transfer
    {
        if (!in_array($selectMode, ['list', 'table', 'tree', 'chained', 'associated'])) {
            throw new RendererException("Transfer mode only supports list、table、tree、chained or associated");
        }
        return $this->set('selectMode', $selectMode);
    }

    /**
     * 左侧列表搜索功能，当设置为  true  时表示可以通过输入部分内容检索出选项项。
     * @default false
     * @param bool $searchable
     * @return Transfer
     */
    public function searchable(bool $searchable = true): Transfer
    {
        return $this->set('searchable', $searchable);
    }

    /**
     * 结果（右则）列表的检索功能，当设置为 true 时，可以通过输入检索模糊匹配检索内容（目前树的延时加载不支持结果搜索功能）
     * @default false
     * @param bool $resultSearchable
     * @return Transfer
     */
    public function resultSearchable(bool $resultSearchable = true): Transfer
    {
        return $this->set('resultSearchable', $resultSearchable);
    }
}