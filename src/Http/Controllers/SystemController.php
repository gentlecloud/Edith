<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Components\Actions\Action;
use Edith\Admin\Components\Columns\Column;
use Edith\Admin\Components\Columns\Item\RadioButtonColumn;
use Edith\Admin\Components\Columns\Item\SwitchColumn;
use Edith\Admin\Components\Columns\Item\TextareaColumn;
use Edith\Admin\Components\Fields\Field;
use Edith\Admin\Components\Fields\GroupField;
use Edith\Admin\Components\Fields\Item\FormList;
use Edith\Admin\Components\Fields\Item\Uploader;
use Edith\Admin\Components\Forms\TabsForm;
use Edith\Admin\Components\Layouts\WaterMark;
use Edith\Admin\Components\Pages\ProCard;
use Edith\Admin\Components\Tables\Table;
use Edith\Admin\Events\ConfigRendererBefore;
use Edith\Admin\Events\ConfigSaveAfter;
use Edith\Admin\Exceptions\RendererException;
use Edith\Admin\Http\Actions\CreateSchemaModalAction;
use Edith\Admin\Models\EdithConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
    protected ?string $daoName = "Edith\Admin\Dao\ConfigDao";

    /**
     * @param Table $table
     * @return Table
     * @throws RendererException
     */
    public function table(Table $table): Table
    {
        $table->column('title', '配置项')->showInSearch()->width(180);
        $table->column('group_name', '分组')->width(120);
        $table->column('name', '字段')->copyable()->showInSearch();
        $table->column('remark', '备注')->editable();

        $table->operation()->rowOnlyEditDestroyAction($this->fields(), 'modal')->width(180);
        $table->toolbar([
            new CreateSchemaModalAction('添加配置项', $this->fields())
        ]);

        $this->title = '配置项';
        return $table->initQuickSaveItemApi();
    }

    /**
     * 表单列
     * @return array
     * @throws RendererException
     */
    public function fields(): array
    {
        $options = [
            'text' => '输入框',
            'digit' => '数字输入框',
            'textarea' => '文本域',
            'uploader' => '图片',
            'file' => '文件',
            'switch' => '开关'
        ];

        return [
            (new Column('title', '标题'))->required(),

            (new RadioButtonColumn('type', '类型'))->valueEnum($options)->initialValue('text'),
            (new Column('group_name', '配置分组'))->required(),
            (new Column('name', '字段名称'))->required(),
            (new SwitchColumn('is_required', '是否必填项'))->initialValue(0)->checkedChildren('是')->unCheckedChildren('否'),
            (new TextareaColumn('remark', '备注'))
        ];
    }

    /**
     * 系统配置
     * @return \Illuminate\Http\JsonResponse
     * @throws RendererException
     */
    public function website()
    {
        $tab = (new TabsForm())->api('put:system/website/store')->footerToolbar();

        $event = new ConfigRendererBefore();
        event($event);
        $group = EdithConfig::distinct()
            ->pluck('group_name');

        $groups = [];
        foreach ($group as $row) {
            $groups[$row] = EdithConfig::where('group_name',$row)
                ->select('title', 'name', 'type', 'value', 'is_required', 'remark')
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
            ->body($tab->initialValues($event->initialValues->toArray()));
        return engine((new WaterMark())->content(edith_config('WEB_SITE_NAME', 'Edith Admin'))->body($page));
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
        DB::beginTransaction();
        try {
            $event = new ConfigSaveAfter($request);
            event($event);
            foreach ($data as $key => $value) {
                if (in_array($key, $event->guard->toArray())) {
                    continue;
                }
                EdithConfig::where('name', $key)->update(['value' => $value]);
                if (in_array($key, ['APP_DEBUG', 'WEB_SITE_SSL', 'EDITH_DEV'])) {
                    $envs[$key] = is_bool($value) ? ($value ? 'true' : 'false') : $value;
                } else {
                    Cache::put($key, $value, 60 * 60 * 24 * 30);
                }
            }
            if (count($envs)) {
                modify_env($envs);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
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
            if (!isset($item['type'])) {
                continue;
            }
            if (!isset($item['name']) && $item['type'] != 'group') {
                throw new RendererException('ProForm input name is required');
            }
            $current = match ($item['type']) {
                'textarea' => Field::make()->component('textarea')
                    ->label($item['title'] ?? $item['name'])
                    ->name($item['name'])
                    ->initialValue($item['value'] ?? null)
                    ->showCount()
                    ->placeholder("请输入" . ($item['title'] ?? ''))
                    ->width($item['width'] ?? 'xl'),
                'switch' => Field::make()->component('switch')
                    ->label($item['title'] ?? $item['name'])
                    ->name($item['name'])
                    ->initialValue(($item['value'] ?? '0') == '1'),
                'uploader' => (new Uploader($item['name'], $item['title']))
                    ->initialValue($item['value'] ?? null)
                    ->button('上传' . $item['title']),
                'list' => (new FormList($item['name'], $item['title']))
                    ->initialValue($item['value'] ?? null)
                    ->items($this->distForm($item['items'] ?? [])),
                'hidden' => Field::make()->component('hidden')->name($item['name'])->initialValue($item['value'] ?? null),
                'group' => (new GroupField($item['title'] ?? '-'))->body($this->distForm($item['items'] ?? [])),
                default => (new Field($item['name'], $item['title'] ?? $item['name']))
                    ->component($item['type'])
                    ->initialValue($item['value'] ?? null)
                    ->placeholder("请输入" . ($item['title'] ?? ''))
                    ->width($item['width'] ?? 'xl'),
            };
            if (isset($item['is_required']) && $item['is_required']) {
                $current->required();
            }

            if (!empty($item['remark'])) {
                $current->extra($item['remark']);
            }

            if (!empty($item['visibleOn'])) {
                $current->visibleOn($item['visibleOn']);
            }
            $items[] = $current;
        }
        return $items;
    }
}