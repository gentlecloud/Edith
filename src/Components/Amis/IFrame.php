<?php
namespace Gentle\Edith\Components\Amis;

/**
 * Amis iFrame
 * 参考文档：https://aisuda.bce.baidu.com/amis/zh-CN/components/iframe
 * @method $this frameBorder(array $frameBorder)                   frameBorder
 * @method $this src(string $src)                                  iframe 地址
 * @method $this allow(string $allow)                              allow 配置
 * @method $this sandbox(string $sandbox)                          sandbox 配置
 * @method $this referrerpolicy(string $referrerpolicy)            referrerpolicy 配置
 * @method $this height($height)                                   iframe 高度 number或string  默认：	"100%"
 * @method $this width($width)                                     iframe 宽度 number或string  默认：	"100%"
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class IFrame extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'iframe';
}