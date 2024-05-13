<?php
namespace Gentle\Edith\Http\Controllers;

use Gentle\Edith\Components\Amis\Action\Action;
use Gentle\Edith\Components\Amis\Crud;
use Gentle\Edith\Components\Amis\Form\FormItem;
use Gentle\Edith\Components\Amis\Form\Select;
use Gentle\Edith\Components\Amis\Form\Textarea;
use Gentle\Edith\Components\Fields\Field;
use Gentle\Edith\Components\Forms\TabsForm;
use Gentle\Edith\Components\Pages\ProCard;
use Gentle\Edith\Events\ConfigRendererAfter;
use Gentle\Edith\Events\ConfigRendererBefore;
use Gentle\Edith\Exceptions\RendererException;
use Gentle\Edith\Models\EdithConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SystemController extends Controller
{
    /**
     * @var string|null
     */
    protected ?string $title = '基础配置';

    /**
     * 控制器服务层
     * @var string|null
     */
    protected ?string $serviceName = "Gentle\Edith\Services\ConfigService";

    /**
     * @param Crud $crud
     * @return Crud
     * @throws RendererException
     */
    public function crud(Crud $crud): Crud
    {
        $crud->column('title', '标题')->width(120);
        $crud->column('group_name', '分组')->copyable();
        $crud->column('name', '字段')->copyable();
        $crud->column('remark', '备注')->quickEdit();

        $crud->operation()->rowOnlyEditDestroyAction($this->controls());
        $crud->onlyBulkDeleteAction()->basicHeaderToolbar($this->controls(), 'modal', '创建配置');

        $this->title = '配置项';
        return $crud->quickSaveApi();
    }

    /**
     * 表单列
     * @return array
     */
    public function controls(): array
    {
        $options = [
            'text' => '输入框',
            'digit' => '数字输入框',
            'textarea' => '文本域',
            'picture' => '图片',
            'file' => '文件',
            'switch' => '开关'
        ];

        return [
            (new FormItem('title', '标题'))->required(),

            (new Select('type', '类型'))->options($options)->value('text'),
            (new FormItem('group_name', '配置分组'))->required(),
            (new FormItem('name', '字段名称'))->required(),
            (new Textarea('remark', '备注'))
        ];
    }

    /**
     * 系统配置
     * @return \Illuminate\Http\JsonResponse
     * @throws RendererException
     */
    public function website()
    {
        $tab = (new TabsForm)->api('api/system/website/store');

        $event = new ConfigRendererBefore();
        event($event);
        $group = EdithConfig::distinct()
            ->pluck('group_name');

        $groups = [];
        foreach ($group as $row) {
            $groups[$row] = EdithConfig::where('group_name',$row)
                ->select('title', 'name', 'type', 'value', 'remark')
                ->get()
                ->toArray();
        }

        $groups = array_merge($groups, $event->custom->toArray());
        foreach ($groups as $label => $group) {
            $tab->tab($label ?: '配置', $this->distForm($group));
        }

        $page = (new ProCard)
            ->title('网站设置')
            ->extra((new Action('刷新'))->refresh())
            ->body($tab->initialValues($event->initialValues));
        return engine($page);
    }

    /**
     * 保存系统配置
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->post();
        $envs = [];
        try {
            foreach ($data as $key => $value) {
                EdithConfig::where('name', $key)->update(['value' => $value]);
                if (in_array($key, ['APP_DEBUG', 'WEB_SITE_SSL', 'EDITH_DEV'])) {
                    $envs[$key] = is_bool($value) ? ($value ? 'true' : 'false') : $value;
                } else {
                    Cache::put($key, $value);
                }
            }
            if (count($envs)) {
                modify_env($envs);
            }
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success('保存成功.');
    }

    /**
     * 解析配置表单
     * @param array $group
     * @return array
     * @throws RendererException
     */
    protected function distForm(array $group): array
    {
        $items = [];
        foreach ($group as $item) {
            if (!isset($item['name'])) {
                throw new RendererException('ProForm input name is required');
            }
            switch ($item['type']) {
                case 'textarea':
                    $items[] = Field::renderer('textarea')
                        ->label($item['title'] ?? $item['name'])
                        ->name($item['name'])
                        ->initialValue($item['value'] ?? null)
                        ->showCount(true)
                        ->placeholder("请输入" . ($item['title'] ?? ''))
                        ->width(600)
                        ->help($item['remark']);
                    break;
                case 'switch':
                    $items[] = Field::renderer('switch')
                        ->label($item['title'] ?? $item['name'])
                        ->name($item['name'])
                        ->initialValue($item['value'] == '1')
                        ->help($item['remark'] ?? null);
                    break;
                case 'image':
                    $items[] = Field::name($item['name'])
                        ->label($item['title'] ?? $item['name'])
                        ->upload()
                        ->initialValue($item['value'])
                        ->title('上传' . $item['title'])
                        ->help($item['remark'] ?? null);
//                $form->image($items['name'],$items['title'] ?? $items['name'])
//                    ->button('上传'.$items['title'])
//                    ->help($items['remark'] ?? null)
//                    ->default($image);

                    break;
                case 'list':
//                $form->formList($items['name'],$items['title'] ?? $items['name'])->columns(function ($form) use ($items) {
//                    foreach ($items['columns'] as $row) {
//                        $this->distForm($form,$row);
//                    }
//                })->width(600);
                    break;
                case 'hidden':
                    $items[] = Field::renderer('hidden')->name($item['name'])->placeholder("请输入")->initialValue($item['value']);
                    break;
                default:
                    $items[] = (new Field($item['name'], $item['title'] ?? $item['name']))
                        ->renderer($item['type'])
                        ->initialValue($item['value'] ?? null)
                        ->placeholder("请输入" . ($item['title'] ?? ''))
                        ->width(600)
                        ->help($item['remark']);
                    break;
            }
        }
        return $items;
    }
}