<?php
namespace Gentle\Edith\Components\Amis\Page;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis JSON 展示组件
 * 参考文档：  https://aisuda.bce.baidu.com/amis/zh-CN/components/json
 * @method $this value($value)                                     json 值，如果是 string 会自动 parse
 * @method $this source(string $source)                            通过数据映射获取数据链中的值
 * @method $this placeholder(string $placeholder)                  占位文本 默认： -
 * @method $this levelExpand(int $levelExpand)                     默认展开的层级 默认： 1
 * @method $this jsonTheme(string $jsonTheme)                      主题，可选twilight和eighties 默认： 'twilight'SearchSpa
 * @method $this ellipsisThreshold(int $ellipsisThreshold)         设置字符串的最大展示长度，点击字符串可以切换全量/部分展示方式，默认展示全量字符串  默认： false
 * @author Chico
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Json extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'json';

    /**
     * 是否可修改
     * @default false
     * @param bool $mutable
     * @return Json
     */
    public function mutable(bool $mutable = true): Json
    {
        return $this->set('mutable', $mutable);
    }

    /**
     * 是否显示数据类型
     * @default false
     * @param bool $displayDataTypes
     * @return Json
     */
    public function displayDataTypes(bool $displayDataTypes = true): Json
    {
        return $this->set('displayDataTypes', $displayDataTypes);
    }
}