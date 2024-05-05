<?php
namespace Gentle\Edith\Components\Amis;

/**
 * Amis PaginationWrapper 分页容器
 * 分页容器组件，可以用来对已有列表数据做分页处理。
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/pagination-wrapper
 * @method $this maxButtons(int $maxButtons)                                   最多显示多少个分页按钮
 * @method $this inputName(string $inputName)                                  输入字段名
 * @method $this outputName(string $outputName)                                输出字段名
 * @method $this perPage(int $perPage = 10)                                    每页显示多条数据
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class PaginationWrapper extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'pagination-wrapper';

    /**
     * 分页显示位置，如果配置为 none 则需要自己在内容区域配置 pagination 组件，否则不显示
     * @var string
     */
    protected string $position = 'top';

    /**
     * 是否显示快速跳转输入框
     * @default false
     * @param bool $showPageInput
     * @return PaginationWrapper
     */
    public function showPageInput(bool $showPageInput = true): PaginationWrapper
    {
        return $this->set('showPageInput', $showPageInput);
    }

    /**
     * 设置分页显示位置，如果配置为 none 则需要自己在内容区域配置 pagination 组件，否则不显示
     * @param string $position
     * @return $this
     * @throws \Exception
     */
    public function position(string $position): PaginationWrapper
    {
        if (!in_array($position, ['top', 'bottom', 'none'])) {
            throw new \Exception("Location only supports setting 'top', 'bottom', 'none'");
        }
        $this->position = $position;
        return $this;
    }
}