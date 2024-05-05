<?php
namespace Gentle\Edith\Components\Amis\Form;

/***
 * Amis InputCity 城市选择器
 * 城市选择器，方便输入城市，可以理解为自动配置了国内城市选项的 Select，支持到县级别。
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-city
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class InputCity extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string 
     */
    protected string $type = 'input-city';

    /**
     * 允许选择城市
     * @default true
     * @param bool $allowCity
     * @return InputCity
     */
    public function allowCity(bool $allowCity = true): InputCity
    {
        return $this->set('allowCity', $allowCity);
    }

    /**
     * 允许选择区域
     * @default true
     * @param bool $allowDistrict
     * @return InputCity
     */
    public function allowDistrict(bool $allowDistrict = true): InputCity
    {
        return $this->set('allowDistrict', $allowDistrict);
    }

    /**
     * 是否出搜索框
     * @default false
     * @param bool $searchable
     * @return InputCity
     */
    public function searchable(bool $searchable = true): InputCity
    {
        return $this->set('searchable', $searchable);
    }

    /**
     * 默认 true 是否抽取值，如果设置成 false 值格式会变成对象，包含 code、province、city 和 district 文字信息。
     * @default true
     * @param bool $extractValue
     * @return InputCity
     */
    public function extractValue(bool $extractValue = true): InputCity
    {
        return $this->set('extractValue', $extractValue);
    }
}