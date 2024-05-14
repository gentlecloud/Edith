<?php
namespace Edith\Admin\Components\Amis;

/**
 * Amis App多页应用
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/app
 * @method $this api($api)                            页面配置接口，如果你想远程拉取页面配置请配置。返回配置路径 json>data>pages，具体格式请参考 pages 属性。
 * @method $this brandName(string $brandName)         应用名称。
 * @method $this logo(string $logo)                   支持图片地址，或者 svg。
 * @method $this header($header)                      顶部区域。
 * @method $this asideBefore($asideBefore)            页面菜单上前面区域。
 * @method $this asideAfter($asideAfter)              页面菜单下前面区域。
 * @method $this footer($footer)                      页面底部？
 * @method $this pages($pages)                        Array<页面配置>具体的页面配置
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class App extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'app';
}