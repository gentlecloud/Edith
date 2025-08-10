<?php
namespace Edith\Admin\Components\Actions;

use Edith\Admin\Components\Displays\Iconfont;
use Edith\Admin\Components\EngineRenderer;
use Edith\Admin\Components\Traits\Attributes\ActionTipAttribute;

/**
 * Antd Popconfirm 气泡确认框
 * @link https://ant.design/components/popconfirm-cn
 * @method $this cancelText(string $value)                              取消按钮文字
 * @method $this icon(string|Iconfont $value)                           自定义弹出气泡 Icon 图标
 * @method $this okText(string $value)                                  确认按钮文字
 * @method $this okType(string $value)                                  确认按钮类型
 * @method $this title(string $value)                                   确认框标题
 * @method $this description(string $value)                             确认内容的详细描述
 * @method $this showCancel(bool $value)                                是否显示取消按钮
 * @method $this reload(string $scopeName)                              刷新目标组件
 */
class PopConfirm extends EngineRenderer
{
    use ActionTipAttribute;

    /**
     * @var string
     */
    protected string $renderer = 'pop-confirm';

    /**
     * @param bool $disabled
     * @return self
     */
    public function disabled(bool $disabled = true): self
    {
        return $this->set('disabled', $disabled);
    }

    /**
     * 确认提交后端 API 接口
     * @param string|array $api
     * @return self
     * @example post:/api/edith/test?id=1&status=2 | { api: 'api', data: {'id': 1, 'status': 1}, method: 'post'} 支持 ${xxx} 表达式
     */
    public function api(string|array $api): self
    {
        return $this->set('api', $api);
    }
}