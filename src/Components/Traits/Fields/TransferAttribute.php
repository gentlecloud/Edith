<?php
namespace Edith\Admin\Components\Traits\Fields;

use Edith\Admin\Components\Columns\Item\TransferColumn;
use Edith\Admin\Components\Fields\Item\Transfer;

/**
 * Antd Transfer
 * @link https://ant.design/components/transfer-cn
 * @method $this actions(array $actions)                                操作文案集合，顺序从上至下。当为字符串数组时使用默认的按钮，当为 ReactNode 数组时直接使用自定义元素 [>, <]
 * @method $this dataSource(array $dataSource)                          数据源，其中的数据将会被渲染到左边一栏中，targetKeys 中指定的除外
 * @method $this selectionsIcon(string $selectionsIcon)                 自定义下拉菜单图标
 * @method $this filterOption(array $filterOption)                      根据搜索内容进行筛选，接收 inputValue option direction 三个参数，(direction 自5.9.0+支持)，当 option 符合筛选条件时，应返回 true，反之则返回 false
 * @method $this locale(array $locale)                                  各种语言	{ itemUnit: string; itemsUnit: string; searchPlaceholder: string; notFoundContent: ReactNode | ReactNode[]; }	{ itemUnit: 项, itemsUnit: 项, searchPlaceholder: 请输入搜索内容 }
 * @method $this pagination(bool|array $pagination)                     boolean | { pageSize: number, simple: boolean, showSizeChanger?: boolean, showLessItems?: boolean }
 * @method $this selectAllLabels(array $pagination)                     自定义顶部多选框标题的集合	(ReactNode | (info: { selectedCount: number, totalCount: number }) => ReactNode)[]
 * @method $this selectedKeys(array $selectedKeys)                      设置哪些项应该被选中	string[] | number[]
 * @method $this status(string $status)                                 设置校验状态	'error' | 'warning'
 * @method $this targetKeys(array $targetKeys)                          显示在右侧框数据的 key 集合	string[] | number[]
 * @method $this titles(array $titles)                                  标题集合，顺序从左至右
 * @method $this styles(array $styles)                                  用于自定义组件内部各语义化结构的行内 style，支持对象或函数	Record<SemanticDOM, CSSProperties> | (info: { props })=> Record<SemanticDOM, CSSProperties>
 * @method $this initApi(string $api)                                   远程请求dataSource接口
 */
trait TransferAttribute
{

    /**
     * 展示为单向样式
     * @param bool $oneWay
     * @return TransferColumn|Transfer|TransferAttribute
     */
    public function oneWay(bool $oneWay = true): self
    {
        return $this->set('oneWay', $oneWay);
    }

    /**
     * 是否展示全选勾选框
     * @param bool $showSelectAll
     * @return TransferColumn|Transfer|TransferAttribute
     */
    public function showSelectAll(bool $showSelectAll = true): self
    {
        return $this->set('showSelectAll', $showSelectAll);
    }

    /**
     * 是否显示搜索框，或可对两侧搜索框进行配置
     * boolean | { placeholder:string,defaultValue:string }
     * @param bool | array $showSearch
     * @return TransferColumn|Transfer|TransferAttribute
     */
    public function showSearch(bool|array $showSearch = true): self
    {
        return $this->set('showSearch', $showSearch);
    }
}