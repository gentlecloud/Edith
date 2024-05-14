<?php
namespace Edith\Admin\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;

class Hash implements CastsInboundAttributes
{
    /**
     * 哈希算法
     * @var string|null
     */
    protected ?string $algorithm = null;

    /**
     * 创建一个新的类型转换类实例
     * @param  string|null  $algorithm
     * @return void
     */
    public function __construct(?string $algorithm = null)
    {
        $this->algorithm = $algorithm;
    }

    /**
     * 转换成将要进行存储的值
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param string $value
     * @param array $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes = []): string
    {
        return is_null($this->algorithm)
            ? bcrypt($value)
            : hash($this->algorithm, $value);
    }
}