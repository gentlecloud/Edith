<?php
namespace Edith\Admin\Components\Traits;

use Edith\Admin\Components\Amis\Action\OnAction;
use Illuminate\Support\Str;

trait FormActions
{
    /**
     * @return OnAction
     */
    public function onAction(): OnAction
    {
        return tap(new OnAction(), function ($action) {
            $this->set('api', $action);
        });
    }

    /**
     * 构建 Amis 基础 OnAction Ajax 请求配置 JSON
     * @param $id
     * @return string[]
     */
    public function makeActionApi($id = null): array
    {
        if (empty($id) && isset($this->data['id'])) {
            $id = $this->data['id'];
        }

        $api = [
            'method' => 'POST'
        ];
        if (is_null($id)) {
            $api['url'] = Str::replaceLast('/create', '', url()->current());
        } else {
            $api['method'] = 'PUT';
            $api['url'] = Str::replaceLast('/edit', '', url()->current()) . '/' . $id;
//            $this->set('initApi', $api['url']);
        }
        $api['data'] = '${values}';
        return $api;
    }
}