<?php
namespace Edith\Admin\Components\Amis\Show;

use Edith\Admin\Components\Amis\AmisRenderer;

/**
 * Amis Code 代码高亮
 * @link https://aisuda.bce.baidu.com/amis/zh-CN/components/code
 * @method $this value(string $value)                             外层 CSS 类名
 * @method $this name(string $name)                               在其他组件中，时，用作变量映射
 * @method $this language(string $language)                       所使用的高亮语言，默认是 plaintext
 * @method $this tabSize(int $tabSize)                            默认 tab 大小  默认： 4
 * @method $this editorTheme(string $editorTheme)                 主题，还有 'vs-dark' 默认： 'vs'
 * @method $this wordWrap(string $wordWrap)                       是否折行 默认：true
 * @author ling
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Code extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = "code";
}


