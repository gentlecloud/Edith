<?php
namespace Edith\Admin\Components\Columns\Item;

use Edith\Admin\Components\Columns\Column as BaseColumn;

class SelectColumn extends BaseColumn
{
    /**
     * @param string|null $dataIndex
     * @param string|null $title
     */
    public function __construct(?string $dataIndex, ?string $title)
    {
        parent::__construct($dataIndex, $title, 'select');
    }

    /**
     * 设置 false 时关闭虚拟滚动
     * @param string $value
     * @return self
     */
    public function virtual(string $value): self
    {
        return $this->fieldProp('virtual', $value);
    }

    /**
     * 是否默认展开下拉菜单
     * @param bool $value
     * @return self
     */
    public function defaultOpen(bool $value): self
    {
        return $this->fieldProp('defaultOpen', $value);
    }

    /**
     * 是否默认高亮第一个选项
     * @param bool $value
     * @return self
     */
    public function defaultActiveFirstOption(bool $value): self
    {
        return $this->fieldProp('defaultActiveFirstOption', $value);
    }

    /**
     * 设置弹窗滚动高度
     * @param int $value
     * @return self
     * @default 256
     */
    public function listHeight(int $value = 256): self
    {
        return $this->fieldProp('listHeight', $value);
    }

    /**
     * 指定可选中的最多 items 数量，仅在 mode 为 multiple 或 tags 时生效
     * @param int $value
     * @return self
     * @default 256
     */
    public function maxCount(int $value): self
    {
        return $this->fieldProp('maxCount', $value);
    }

    /**
     * 当下拉列表为空时显示的内容
     * @param string $value
     * @return self
     * @default 256
     */
    public function notFoundContent(string $value): self
    {
        return $this->fieldProp('notFoundContent', $value);
    }

    /**
     * 是否默认高亮第一个选项
     * @param string|bool|int $value
     * @return self
     */
    public function popupMatchSelectWidth(string|int|bool $value): self
    {
        return $this->fieldProp('popupMatchSelectWidth', $value);
    }

    /**
     * 配置是否可搜索
     * @param bool $value
     * @return self
     */
    public function showSearch(bool $value = true): self
    {
        return $this->fieldProp('showSearch', $value);
    }

    /**
     * 控制搜索文本
     * @param string $value
     * @return self
     */
    public function searchValue(string $value): self
    {
        return $this->fieldProp('searchValue', $value);
    }

    /**
     * 自定义的选择框后缀图标。以防止图标被用于其他交互，替换的图标默认不会响应展开、收缩事件，可以通过添加 pointer-events: none 样式透传。
     * @param array|string $icon
     * @return self
     */
    public function suffixIcon(array|string $icon): self
    {
        return $this->fieldProp('suffixIcon', $icon);
    }

    /**
     * 自定义的多选框清除图标
     * @param array|string $icon
     * @return self
     */
    public function removeIcon(array|string $icon): self
    {
        return $this->fieldProp('removeIcon', $icon);
    }

    /**
     * 设置 Select 的模式为多选或标签
     * @param string $value
     * @return self
     */
    public function mode(string $value): self
    {
        return $this->fieldProp('mode', $value);
    }

    /**
     * @return self
     */
    public function multiple(): self
    {
        $this->fieldProp('mode', 'multiple');
        return $this;
    }

    /**
     * 是否把每个选项的 label 包装到 value 中，会把 Select 的 value 类型从 string 变为 { value: string, label: ReactNode } 的格式
     * @param bool $value
     * @return self
     */
    public function labelInValue(bool $value): self
    {
        $this->fieldProp('labelInValue', $value);
        return $this;
    }

    /**
     * 自定义节点 label、value、options、groupLabel 的字段
     * @example { label: label, value: value, options: options, groupLabel: label }
     * @param array $config
     * @return self
     */
    public function fieldNames(array $config): self
    {
        return $this->fieldProp('fieldNames', $config);
    }
}