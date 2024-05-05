<?php
namespace Gentle\Edith\Components\Amis\Form;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Hidden 隐藏字段
 * 参考文档： https://baidu.github.io/amis/zh-CN/components/form/hidden
 * @method $this name(string $name)                      字段名称
 * @method $this value($value)                           表单值
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Hidden extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'hidden';

    /**
     * construct Hidden
     * @param string|null $name
     */
    public function __construct(?string $name = null)
    {
        parent::__construct();
        $this->set('name', $name);
    }
}