<?php
namespace Gentle\Edith\Components\Amis;

/**
 * Amis List 列表
 * 列表展示，不支持配置初始化接口初始化数据域，所以需要搭配类似像Service这样的，具有配置接口初始化数据域功能的组件，或者手动进行数据域初始化，然后通过source属性，获取数据链中的数据，完成数据展示。
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/list
 * @method $this title(string $title)                          标题
 * @method $this source(string $source)                        数据源, 获取当前数据域变量，支持数据映射 默认： ${items}
 * @method $this placeholder(string $placeholder)              当没数据的时候的文字提示
 * @method $this headerClassName(string $headerClassName)      顶部外层 CSS 类名
 * @method $this footerClassName(string $footerClassName)      底部外层 CSS 类名
 * @method $this listItem(array $listItem)                     配置单条信息
 * @method $this itemAction($itemAction)                       单行点击操作 可以实现点击某一行后进行操作，支持 action 里的所有配置，比如弹框、刷新其它组件等。
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class AmisList extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'list';
}