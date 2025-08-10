<?php
namespace Edith\Admin\Components\Fields;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd DescriptionsItem
 * @method $this label(string $value)                               内容的描述
 * @method $this tooltip(string $value)                             内容的补充描述，hover 后显示
 * @method $this span(int $value)                                   包含列的数量
 * @method $this valueType(string $value)                           格式化的类型
 * @method $this valueEnum(array $value)                            当前列值的枚举 valueEnum
 * @method $this dataIndex(string $value)                           返回数据的 key 与 ProDescriptions 的 request 配合使用，用于配置式的定义列表
 * @method $this value(string $value)                               描述列表的值
 */
class DescriptionsItem extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'descriptions-item';

    /**
     * @param string|null $label
     * @param string|null $dataIndex
     */
    public function __construct(?string $label = null, ?string $dataIndex = null)
    {
        parent::__construct();
        !is_null($label) && $this->set('label', $label);
        !is_null($dataIndex) && $this->set('dataIndex', $dataIndex);
    }

    /**
     * 是否自动缩略
     * @param bool $value
     * @return self
     */
    public function ellipsis(bool $value = true): self
    {
        return $this->set('ellipsis', $value);
    }

    /**
     * 是否支持复制
     * @param bool $value
     * @return self
     */
    public function copyable(bool $value = true): self
    {
        return $this->set('copyable', $value);
    }

    /**
     * 在编辑表格中是否可编辑的，函数的参数和 table 的 render 一样    false | (text: any, record: T,index: number) => boolean
     * @param bool|array $value
     * @return self
     */
    public function editable(bool|array $value = true): self
    {
        return $this->set('ellipsis', $value);
    }
}