<?php
namespace Gentle\Edith\Traits;

trait DateTimeFormatter
{
    /**
     * 模型日期序列化
     * @param \DateTimeInterface $date
     * @return string
     * @author Gentle Gentle.Org.Cn
     */
    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format($this->getDateFormat());
    }
}
