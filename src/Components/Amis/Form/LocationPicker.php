<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis Form LocationPicker 地理位置
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/location-picker
 * @method $this vendor(string $vendor)                    地图厂商，目前只实现了百度地图 默认： baidu
 * @method $this ak(string $ak)                            地图厂商的 ak
 * @method $this placeholder(string $placeholder)          默认提示 默认：'请选择位置'
 * @method $this coordinatesType(string $coordinatesType)  默为百度坐标，可设置为'gcj02' 默认： 'bd09'
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class LocationPicker extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'location-picker';

    /**
     * 输入框是否可清空
     * @default false
     * @param bool $clearable
     * @return LocationPicker
     */
    public function clearable(bool $clearable = true): LocationPicker
    {
        return $this->set('clearable', $clearable);
    }
}