<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Components\Amis\Crud;
use Edith\Admin\Components\Tables\Table;
use Edith\Admin\Components\Traits\Resource;
use Edith\Admin\Exceptions\RendererException;
use Edith\Admin\Exceptions\DaoException;
use Edith\Admin\Traits\Datasource;
use Edith\Admin\Traits\FormValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
        } else if (method_exists($this, 'table')) {
            $body = $this->table(new Table());
        }
        return engine($body, $this->title);
    }

    /**
     * 新增页面
     * @return \Illuminate\Http\JsonResponse
     * @throws DaoException
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
        $this->checkFormRules($request);
        try {
            $this->dao()->store($request->post());
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success('添加成功.');
    }

    /**
     * 编辑页面
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws RendererException|DaoException
     */
    public function edit($id)
    {
        return engine($this->renderFormPage($id));
   }

    /**
     * 表单更新
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $data = $request->except(['ids', '_action']);
        if (!in_array($request->input('_action'), ['quickSave', 'editable'])) {
            if (!isset($data['id'])) {
                $request->request->add(['id' => $id]);
            }
            $this->checkFormRules($request, true);
        }
        try {
            switch ($id) {
                case str_contains(',', $id):
                case 'quickSave':
                    $ids = $id != 'quickSave' ? $id : (is_string($request->input('ids')) ? explode(",", urldecode($request->input('ids'))) : $request->input('ids'));
                    if ($ids) {
                        foreach ((array) $ids as $id) {
                            $this->dao()->update($data, $id);
                        }
                    } else if (isset($data['rowsDiff']) || isset($data['rows'])) {
                        $rows = $data['rowsDiff'] ?? $data['rows'];
                        foreach ($rows as $row) {
                            $this->dao()->update($row, $row['id']);
                        }
                    } else {
                        throw new \Exception('参数错误.', -10022);
                    }
                    break;
                case 'saveOrder':
                    if (!isset($data['rows'])) {
                        throw new \Exception('参数错误.', -10022);
                    }
                    $this->dao()->saveOrder($data['rows']);
                    break;
                default:
                    unset($data['children']);
                    $this->dao()->update($data, $id);
                    break;
            }
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success('保存成功.');
    }

    /**
     * 详情页面
     * @param $id
     * @param Request $request
     * @return JsonResponse
     * @throws DaoException
     */
    public function show($id, Request $request)
    {
        if ($request->input('_action') == 'datasource') {
            return success('fetch succeed.', $this->dao()->get($id));
        }
        return success('fetch succeed.', $this->dao()->get($id));
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
            $this->dao()->destroy($id);
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success('删除成功.');
    }
}