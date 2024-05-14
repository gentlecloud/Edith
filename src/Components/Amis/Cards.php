<?php
namespace Edith\Admin\Components\Amis;

use Illuminate\Support\Collection;

/**
 * Amis Cards 卡片组
 * 参考文档：https://aisuda.bce.baidu.com/amis/zh-CN/components/cards
 * @method $this title(string $title)                           标题
 * @method $this source(string $source)                         数据源, 获取当前数据域中的变量
 * @method $this placeholder(string $placeholder)               当没数据的时候的文字提示
 * @method $this headerClassName(string $headerClassName)       顶部外层 CSS 类名
 * @method $this footerClassName(string $footerClassName)       底部外层 CSS 类名
 * @method $this itemClassName(string $itemClassName)           卡片 CSS 类名
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Cards extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'cards';

    /**
     * 卡片组卡片信息
     * @var array
     */
    protected array $card;

    /**
     * construct Cards
     */
    public function __construct()
    {
        parent::__construct();
        $this->card = ['body' => new Collection()];
    }

    /**
     * 卡片信息
     * @param string|null $name
     * @param string|null $label
     * @return Card
     */
    public function card(?string $name = null, ?string $label = null): Card
    {
        $card = new Card();
        !is_null($name) && $card->set('name', $name);
        !is_null($label) && $this->set('label', $label);
        return tap($card, function ($value) {
            $this->card['body']->push($value);
        });
    }

    /**
     * 卡片组信息
     * @param array $cards
     * @return $this
     */
    public function cards(array $cards): Cards
    {
        $this->card = ['body' => $cards];
        return $this;
    }
}