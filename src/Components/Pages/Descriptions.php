<?php
namespace Edith\Admin\Components\Pages;

use Edith\Admin\Components\EngineRenderer;
use Illuminate\Support\Collection;

/**
 * Antd ProDescriptions
 * @link https://procomponents.ant.design/components/descriptions#prodescriptions
 * @method $this title(string $value)                               描述列表的标题，显示在最顶部
 * @method $this tooltip(string $value)                             内容的补充描述，hover 后显示
 * @method $this extra(array|object $value)                         描述列表的操作区域，显示在右上方
 * @method $this size(string $value)                                设置列表的大小。可以设置为 middle 、small，或不填（只有设置 bordered={true} 生效）	default | middle | small
 * @method $this layout(string $value)                              描述布局	horizontal | vertical
 * @method $this emptyText(string $value)                           列表为空时显示文字
 * @method $this column(array|int $value)                           一行的 ProDescriptionsItems 数量，可以写成像素值或支持响应式的对象写法 { xs: 1, sm: 2, md: 3}
 * @method $this editable(array $value)                             编辑的相关配置
 */
class Descriptions extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'descriptions';

    /**
     * @var Collection|null
     */
    protected ?Collection $columns;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->columns = new Collection();
    }

    /**
     * 是否展示边框
     * @param bool $value
     * @return self
     */
    public function bordered(bool $value = true): self
    {
        return $this->set('bordered', $value);
    }

    /**
     * 配置 ProDescriptions.Item 的 colon 的默认值
     * @param bool $value
     * @return self
     */
    public function colon(bool $value = true): self
    {
        return $this->set('colon', $value);
    }

    /**
     * @param array $columns
     * @return self
     */
    public function columns(array $columns): self
    {
        return $this->set('columns', new Collection($columns));
    }

    /**
     * @param array $items
     * @return self
     */
    public function items(array $items): self
    {
        return $this->set('items', new Collection($items));
    }
}