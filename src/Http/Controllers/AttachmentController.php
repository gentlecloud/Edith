<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Components\Actions\Action;
use Edith\Admin\Components\Columns\Column;
use Edith\Admin\Components\Columns\Item\HiddenColumn;
use Edith\Admin\Components\Displays\Each;
use Edith\Admin\Components\Displays\Text;
use Edith\Admin\Components\Fields\Field;
use Edith\Admin\Components\Fields\Item\UploadDragger;
use Edith\Admin\Components\Forms\ModalForm;
use Edith\Admin\Components\Layouts\Space;
use Edith\Admin\Components\Pages\PageContainer;
use Edith\Admin\Components\Pages\ProCard;
use Edith\Admin\Components\Tables\Table;
use Edith\Admin\Exceptions\RendererException;
use Edith\Admin\Exceptions\DaoException;
use Edith\Admin\Facades\EdithAdmin;
use Edith\Admin\Http\Actions\CreateSchemaModalAction;
use Edith\Admin\Http\Actions\DeleteAction;
use Edith\Admin\Models\EdithAttachment;
use Edith\Admin\Models\EdithAttachmentCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * @var string|null
     */
    protected ?string $title = '附件';

    /**
     * @var string|null
     */
    protected ?string $daoName = 'Edith\Admin\Dao\AttachmentDao';

    /**
     * 自定义渲染页面
     * @return PageContainer
     * @throws RendererException
     */
    public function render()
    {
        $page = (new ProCard())->split('vertical');
        $page->body([
            (new ProCard())->colSpan('384px')->ghost()->body($this->categoryPage()),
            (new ProCard())->title('${categoryName}')->body($this->table(new Table))
        ]);
        return (new PageContainer())->data([
            'categoryId' => 0,
            'categoryName' => '默认目录',
        ])->body($page);
    }

    /**
     * @param Table $table
     * @return Table
     * @throws RendererException
     */
    public function table(Table $table): Table
    {
//        $table->column('category_name', '目录')->width(120)->hideInSearch();
        $table->column('name', '附件名称')->showInSearch();
        $table->column('url', '外链')->copyable()->width(300);
        $table->column('size', '大小')->sorter()->hideInSearch();
        $table->column('ext', '扩展名')->sorter();
        $table->column('preview', '预览')->valueType('image');
        $table->column('created_at', '上传时间');
        $table->column('created_at', '上传时间')->valueType('dateRange')->showOnlyInSearch();

        $table->operation()->rowOnlyDestroyAction();
        $table->toolbar([
            $this->uploadForm()
        ]);

        return $table->scopeName('attachment')->initApi('attachments/list?category_id=${categoryId}');
    }

    /**
     * 附件目录浏览
     * @return Table
     * @throws RendererException
     */
    protected function categoryPage()
    {
        $table = (new Table())->pageSize(80)->initApi('attachments/category');
        $table->column('title', '目录名称');

        $table->operation()
            ->width(130)
            ->items([
                (new Action('浏览'))->carryData([
                    'categoryId' => '${id}',
                    'categoryName' => '${title}'
                ])->reload('attachment')->type('link'),
                (new DeleteAction('删除', '是否确定要删除${title}目录？'))
                    ->api('delete:attachments/category/${id}')
                    ->visibleOn('${id != 0}')
            ]);
        $table->toolbar([
            (new CreateSchemaModalAction('创建目录', $this->categoryForm()))->api('post:attachments/category')
        ]);
        $table->rowSelection(false);
        return $table->set('search', false);
    }

    /**
     * 附件目录表单
     * @return array
     * @throws RendererException
     */
    protected function categoryForm(): array
    {
        return [
            (new Column('title', '目录名称'))->required(),
            (new HiddenColumn('obj_type'))->initialValue('PLATFORM'),
            (new HiddenColumn('obj_id'))->initialValue(EdithAdmin::auth()->platformId()),
        ];
    }

    /**
     * @return ModalForm
     * @throws RendererException
     */
    protected function uploadForm()
    {
        $button =  (new Action('上传附件'))
            ->type('primary')
            ->size('xl')
            ->icon('icon-plus-circle')
            ->actionType('pro-form');
        $categories = EdithAttachmentCategory::select('title as label', 'id as value')->get()->toArray();

        return (new ModalForm($button))->columns([
            (new Field('category_id', '附件目录'))->component('select')->options(array_merge([['value' => 0, 'label' => '默认目录']], $categories))->initialValue(0)->required(),
            (new UploadDragger('attachments', '上传附件'))
                ->maxCount(9)
                ->reload('attachment')
                ->valueType('file')
                ->action('/api/attachments/upload?category_id=${category_id}'),
            (new Each)->name('${attachments}')
                ->visibleOn('${attachments}')
                ->items((new Text('${url}'))->copyable())
                ->withSpace((new Space())->direction('vertical')->style(['marginBottom' => '20px']))
        ])->width(960)->submitter(false)->title('上传附件');
    }

    /**
     * 附件管理
     * @param Request $request
     * @return JsonResponse
     */
    public function attachments(Request $request)
    {
        $pictureCategoryId = $request->input('pictureCategoryId');
        $pictureSearchName = $request->input('pictureSearchName');
        $pictureSearchDate = $request->input('pictureSearchDate');

        $query = EdithAttachment::query()->when($request->input('accept'), function ($query) {
            $mime = str_replace('*', '', request()->input('accept'));
            $query->where('mime', 'like', $mime . '%' );
        });

        if ($pictureCategoryId) {
            $query->where('category_id',$pictureCategoryId);
        }

        if ($pictureSearchName) {
            $query->where('name','like',"%$pictureSearchName%");
        }

        if ($pictureSearchDate) {
            $query->whereBetween('created_at', [$pictureSearchDate[0], $pictureSearchDate[1]]);
        }

        $pictures = $query->where('platform_id', EdithAdmin::auth()->platformId())
            ->orderByDesc('id')
            ->paginate(12);

        $pagination = [];
        $data = [];

        if ($pictures) {
            $getPictures = $pictures->toArray();
            $data = $getPictures['data'];

            $pagination['defaultCurrent'] = 1;
            $pagination['current'] = $getPictures['current_page'];
            $pagination['pageSize'] = $getPictures['per_page'];
            $pagination['total'] = $getPictures['total'];
        }

        $categories = EdithAttachmentCategory::where('obj_type', 'ADMIN')->where('obj_id', EdithAdmin::auth()->platformId())->get();

        $attachment['lists'] = $data;
        $attachment['pagination'] = $pagination;
        $attachment['categories'] = $categories;

        return success('获取成功！', $attachment);
    }

    /**
     * 上传文件
     * @param Request $request
     * @return JsonResponse
     * @throws DaoException
     */
    public function upload(Request $request)
    {
        $platform_id = app('edith.auth')->platformId();
        try {
            $result = $this->dao()->upfile($request, $platform_id);
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success('上传成功', $result);
    }
}