<?php
namespace Gentle\Edith\Components\Traits;

use Gentle\Edith\Components\Amis\Action\Button;
use Gentle\Edith\Components\Amis\Form\Form;
use Gentle\Edith\Components\Forms\ProForm;
use Gentle\Edith\Components\Forms\SchemaForm;
use Gentle\Edith\Components\Pages\ProCard;
use Gentle\Edith\Exceptions\RendererException;
use Illuminate\Support\Str;

trait Resource
{
    /**
     * 生成表单页 JSON
     * @param $id
     * @return object
     * @throws RendererException|\Gentle\Edith\Exceptions\ServiceException
     */
    protected function renderFormPage($id = null)
    {
        if (method_exists($this, 'controls')) {
            $form = (new Form)->controls($this->controls());
        } else if (method_exists($this, 'fields')) {
            $form = (new ProForm)->columns($this->fields());
        } else if (method_exists($this, 'columns')) {
            $form = (new SchemaForm)->columns($this->columns());
        } else if (method_exists($this, 'form')) {
            $form = $this->form();
        } else {
            throw new RendererException('表单未定义');
        }

        if (!isset($this->initialValues) && method_exists($form, 'initialValues')) {
            if (!empty($id)) {
                $form->initialValues($this->service()->get($id));
            } else {
                $form->initialValues($this->service()->getInitialValues());
            }
        }
        return (new ProCard)->title(($id ? '编辑' : '添加') . $this->title)->headerBordered()->extra((new Button('返回'))->actionType('goBack'))->body($form);
    }

    /**
     * 是否为创建页面
     * @return bool
     */
    protected function isCreate(): bool
    {
        return Str::endsWith(\request()->route()->getName(), ['/create', '/store']);
    }

    /**
     * 是否为编辑页面
     * @return bool
     */
    public function isEdit(): bool
    {
        return Str::endsWith(\request()->route()->getName(), ['/edit', '/update']);
    }
}