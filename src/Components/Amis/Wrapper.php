<?php
namespace Edith\Admin\Components\Amis;

/**
 * Amis Wrapper 包裹容器
 * 简单的一个包裹容器组件，相当于用 div 包含起来，最大的用处是用来配合 css 进行布局。
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/wrapper
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Wrapper extends AmisRenderer
{
    /**+
     * Amis 组件类型
     * @var string
     */
    protected string $type = 'wrapper';

    /**
     * 支持: xs、sm、md和lg
     * @var string|null
     */
    protected ?string $size;


    /**
     * 包裹容器大小
     * @param string $size xs、sm、md、lg
     * @return $this
     * @throws \Exception
     */
    public function size(string $size): Wrapper
    {
        if (!in_array($size, ['xs', 'sm', 'md', 'lg'])) {
            throw new \Exception("Size only supports' xs', 'sm', 'md', 'lg'");
        }
        $this->size = $size;
        return $this;
    }
}