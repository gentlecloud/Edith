<?php
namespace Edith\Admin\Components\Columns\Item;

use Edith\Admin\Components\Columns\Column;

/**
 * Antd FormList
 * @link https://procomponents.ant.design/components/group
 * @method $this creatorRecord(array $record)                               新增一行的默认值
 * @method $this creatorButtonProps(array $props)                           新建一行按钮的配置 {creatorButtonText:"新建一行"}
 * @method $this min(int $min)                                              最少条目，删除时如果当前数据条目少于该数则无法删除
 * @method $this max(int $max)                                              最多条目，新增或复制时如果当前数据条目多于该数则无法新增或复制
 * @method $this copyIconProps(array|bool $props)                           复制按钮的配置，false 可以取消 { Icon?: React.FC<any>; tooltipText?: string; } | false
 * @method $this deleteIconProps(array|bool $props)                         删除按钮的配置，false 可以取消 { Icon?: React.FC<any>; tooltipText?: string; } | false
 * @method $this upIconProps(array|bool $props)                             向上排序按钮的配置，false 可以取消 { Icon?: React.FC<any>; tooltipText?: string; } | false
 * @method $this downIconProps(array|bool $props)                           向下排序按钮的配置，false 可以取消 { Icon?: React.FC<any>; tooltipText?: string; } | false
 */
class FormListColumn extends Column
{

    /**
     * construct Digit Column
     * @param string|null $dataIndex
     * @param string|null $title
     */
    public function __construct(?string $dataIndex = null, ?string $title = null)
    {
        parent::__construct($dataIndex, $title, 'formList');
    }

    /**
     * @param bool $show
     * @return self
     */
    public function alwaysShowItemLabel(bool $show = true): self
    {
        return $this->set('alwaysShowItemLabel', $show);
    }

    /**
     * 是否开启箭头按钮排序
     * @param bool $show
     * @return self
     */
    public function arrowSort(bool $show = true): self
    {
        return $this->set('arrowSort', $show);
    }
}