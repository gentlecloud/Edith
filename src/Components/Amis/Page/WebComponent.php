<?php
namespace Edith\Admin\Components\Amis\Page;

use Edith\Admin\Components\Amis\AmisRenderer;

/**
 * Amis Web Component
 * 专门用来渲染 web component 的组件，可以通过这种方式来扩展 amis 组件，比如使用 Angular。
 * <random-number prefix="hello" class="my-class"></random-number>
 * {
 *   "type": "web-component",
 *   "tag": "random-number",
 *   "props": {
 *      "prefix": "hello",
 *      "class": "my-class"
 *    }
 *  }
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/web-component
 * @method $this tag(string $tag)                  具体使用的 web-component 标签
 * @method $this props(array $props)               标签上的属性
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class WebComponent extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'web-component';
}