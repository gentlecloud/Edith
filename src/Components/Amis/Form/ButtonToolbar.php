<?php
namespace Edith\Admin\Components\Amis\Form;

/**
 * Amis Form Button-Toolbar 按钮工具栏
 * 默认按钮会独占一行，如果想让多个按钮并排方式，可以使用 button-toolbar 组件包裹起来，另外还有能用 button-group 来在展现上更紧凑。
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/button-toolbar
 * @method $this buttons(array $buttons)                        按钮组
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class ButtonToolbar extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'button-toolbar';
}