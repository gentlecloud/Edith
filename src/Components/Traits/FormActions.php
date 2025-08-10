<?php
namespace Edith\Admin\Components\Traits;

use Illuminate\Support\Str;

trait FormActions
{

    /**
     * 构建保存接口请求 API
     * @param $id
     * @return string
     */
    public function makeActionApi($id = null): string
    {
        $method = 'POST';
        if (str_contains($id, '/')) {
            $url = $id;
            $id = null;
        }
        if (empty($id) && isset($this->data['id'])) {
            $id = $this->data['id'];
        }

        if (is_null($id)) {
            empty($url) && $url = Str::replaceLast('/create', '', \request()->path());
        } else {
            $method = 'PUT';
            empty($url) && $url = Str::replaceLast('/edit', '', \request()->path());
        }
        if (!empty($id) && !Str::contains($url, $id)) {
            $url .= '/' . $id;
        }
        return $method . ':' . Str::replaceFirst('api/', '', $url);
    }
}