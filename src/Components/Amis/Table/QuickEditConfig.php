<?php
namespace Gentle\Edith\Components\Amis\Table;

use Gentle\Edith\Components\Amis\AmisRenderer;
use Gentle\Edith\Exceptions\RendererException;

/**
 * Crud QuickEditConfig
 * @method $this onText(string $onText)                                          Switch 启用提示
 * @method $this offText(string $offText)                                        Switch 禁用提示
 * @method $this quickEditEnabledOn(string $quickEditEnabledOn)                  开启快速编辑条件表达式
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class QuickEditConfig extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-text';

    /**
     * @var bool|array
     */
    protected $saveImmediately = true;

    /**
     * 编辑模式，inline 为行内编辑，popOver 为浮层编辑
     * @param string $mode 'inline' | 'popOver'
     * @return QuickEditConfig
     * @throws RendererException
     * @default popOver
     */
    public function mode(string $mode): QuickEditConfig
    {
        if (!in_array($mode, ['inline', 'popOver'])) {
            throw new RendererException("QuickEditConfig mode only supports 'inline' | 'popOver'");
        }
        return $this->set('mode', $mode);
    }

    /**
     * 是否修改后即时保存，一般需要配合quickSaveItemApi接口使用，也可以直接配置Api
     * @param  bool|array $saveImmediately boolean | { api: API }
     * @return QuickEditConfig
     */
    public function saveImmediately(bool|array $saveImmediately = true): QuickEditConfig
    {
        return $this->set('saveImmediately', $saveImmediately);
    }
}