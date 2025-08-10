<?php
namespace Edith\Admin\Components\Pages;

use Edith\Admin\Components\BaseRenderer;
use Illuminate\Support\Collection;

/**
 * Antd AnchorItem
 * @method $this key(string|int $value)                             唯一标志
 * @method $this href(string $value)                                锚点链接
 * @method $this target(string $value)                              该属性指定在何处显示链接的资源
 * @method $this title(string $value)                               文字内容
 */
class AnchorItem extends BaseRenderer
{
    /**
     * @param string $key
     * @param string $href
     * @param string|null $title
     */
    public function __construct(string $key, string $href, ?string $title = null)
    {
        $this->set('key', $key)->set('href', $href);
        !is_null($title) && $this->set('title', $title);
    }

    /**
     * 替换浏览器历史记录中的项目 href 而不是推送它
     * @param bool $replace
     * @return self
     */
    public function replace(bool $replace = true): self
    {
        return $this->set('replace', $replace);
    }

    /**
     * @param string|array $key
     * @param string|null $href
     * @return AnchorItem|self
     */
    public function children(string|array $key, string $href = null): AnchorItem|self
    {
        if (is_array($key)) {
            return $this->set('children', new Collection($key));
        } else {
            if (!isset($this->children)) {
                $this->children = new Collection();
            }
            return tap(new AnchorItem($key, $href), function ($value) {
                $this->children->push($value);
            });
        }
    }
}