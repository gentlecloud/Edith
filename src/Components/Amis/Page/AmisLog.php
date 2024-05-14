<?php
namespace Edith\Admin\Components\Amis\Page;

use Edith\Admin\Components\Amis\AmisRenderer;

/**
 * Amis Log 实时日志
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/log
 * @method $this height($height)                        展示区域高度 默认 500
 * @method $this placeholder(string $placeholder)       加载中的文字
 * @method $this encoding(string $encoding)             返回内容的字符编码 默认： utf-8
 * @method $this source(string $source)                 接口
 * @method $this rowHeight($rowHeight)                  设置每行高度，将会开启虚拟渲染
 * @method $this maxLength($maxLength)                  最大显示行数
 * @method $this operation(array $operation)            可选日志操作：['stop','restart',clear','showLineNumber','filter']
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class AmisLog extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'log';

    /**
     * 是否自动滚动
     * @default true
     * @param bool $autoScroll
     * @return AmisLog
     */
    public function autoScroll(bool $autoScroll = true): AmisLog
    {
        return $this->set('autoScroll', $autoScroll);
    }
}