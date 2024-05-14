<?php
namespace Edith\Admin\Components\Amis;

/**
 * Panel 面板
 * 可以把相关信息以面板的形式展示到一块。
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/panel
 * @method Panel headerClassName(string $headerClassName)                          header 区域的类名
 * @method Panel footerClassName(string $footerClassName)                          footer 区域的类名
 * @method Panel actionsClassName(string $actionsClassName)                        actions 区域的类名
 * @method Panel bodyClassName(string $bodyClassName)                              body 区域的类名
 * @method Panel title($title)                                                     标题
 * @method Panel header($header)                                                   头部容器
 * @method Panel footer($footer)                                                   底部容器
 * @method Panel actions(array $actions)                                           按钮区域
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Panel extends AmisRenderer
{
    /**
     * Amis 组件类型
     * @var string
     */
    protected string $type = 'panel';

    /**
     * 是否固定底部容器
     * @param bool $affixFooter
     * @return Panel
     */
    public function affixFooter(bool $affixFooter = true): Panel
    {
        return $this->set('affixFooter', $affixFooter);
    }
}