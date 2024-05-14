<?php
namespace Edith\Admin\Components\Amis\Table;

use Edith\Admin\Components\BaseRenderer;

/**
 * Crud QuickFilterConfig
 * @method $this options(array $options)                    静态选项 Array<any>
 * @method $this source($source)                            选项 API 接口 string | API
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class QuickFilterConfig extends BaseRenderer
{

    /**
     * 是否支持多选
     * @default false
     * @param bool $multiple
     * @return QuickFilterConfig
     */
    public function multiple(bool $multiple = true): QuickFilterConfig
    {
        return $this->set('multiple', $multiple);
    }

    /***
     * 严格模式，开启严格模式后，会采用 JavaScript 严格想等比较
     * @default false
     * @param bool $strictMode
     * @return QuickFilterConfig
     */
    public function strictMode(bool $strictMode = true): QuickFilterConfig
    {
        return $this->set('strictMode', $strictMode);
    }
}