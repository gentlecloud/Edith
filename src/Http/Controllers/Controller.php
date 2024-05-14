<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Components\Amis\Crud;
use Edith\Admin\Components\Traits\Resource;
use Edith\Admin\Exceptions\RendererException;
use Edith\Admin\Exceptions\ServiceException;
use Edith\Admin\Traits\Datasource;
use Edith\Admin\Traits\FormValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

/**
 * 翼搭 Edith Cms
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Controller extends BaseController
{
    use Resource, Datasource, FormValidator;

    /**
     * 控制器面包屑标题
     * @var string|null
     */
    protected ?string $title;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $body = null;
        if ($method = $request->input('_action')) {
            if (!method_exists($this, $method)) {
                return error('当前控制器不存在该操作行为');
            }
            return success('fetch succeed.', $this->$method());
        } else if (method_exists($this, 'render')) {
            $body = $this->render();
        } else if (method_exists($this, 'crud')) {
            $body = $this->crud(new Crud);
        }
        return engine($body, $this->title);
    }

    /**
     * 新增页面
     * @return \Illuminate\Http\JsonResponse
     * @throws ServiceException
     * @throws RendererException
     */
    public function create()
    {
        return engine($this->renderFormPage());
    }

    /**
     * 表单保存
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->service()->store($request->post());
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success('添加成功.');
    }

    /**
     * 编辑页面
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws RendererException|ServiceException
     */
    public function edit($id)
    {
        return engine($this->renderFormPage($id));
   }

    /**
     * 表单更新
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->except(['ids']);
        try {
            switch ($id) {
                case 'quickSave':
                    if (isset($data['rowsDiff']) || isset($data['rows'])) {
                        $rows = $data['rowsDiff'] ?? $data['rows'];
                        foreach ($rows as $row) {
                            $this->service()->update($row, $row['id']);
                        }
                    } else if ($request->input('ids')) {
                        $ids = explode(",", urldecode($request->input('ids')));
                        foreach ($ids as $id) {
                            $this->service()->update($data, $id);
                        }
                    } else {
                        throw new \Exception('参数错误.', -10022);
                    }
                    break;
                case 'saveOrder':
                    if (!isset($data['rows'])) {
                        throw new \Exception('参数错误.', -10022);
                    }
                    $this->service()->saveOrder($data['rows']);
                    break;
                default:
                    unset($data['children']);
                    $this->service()->update($data, $id);
                    break;
            }
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success('保存成功.');
    }

    /**
     * 详情页面
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws ServiceException
     */
    public function show(Request $request, $id)
    {
        if ($request->input('_action') == 'datasource') {
            return success('fetch succeed.', $this->service()->get($id));
        }
        return engine();
    }

    /**
     * 删除模型数据
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            if (str_contains($id, ',')) {
                $id = explode(',', $id);
            }
            $this->service()->destroy($id);
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success('删除成功.');
    }
}