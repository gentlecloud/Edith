<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Components\Amis\Action\Action;
use Edith\Admin\Components\Amis\Action\Button;
use Edith\Admin\Components\Amis\Action\Dialog;
use Edith\Admin\Components\Amis\Container;
use Edith\Admin\Components\Amis\Crud;
use Edith\Admin\Components\Amis\Form\Form;
use Edith\Admin\Components\Amis\Form\FormItem;
use Edith\Admin\Components\Amis\Form\Group;
use Edith\Admin\Components\Amis\Form\Hidden;
use Edith\Admin\Components\Amis\Form\InputFile;
use Edith\Admin\Components\Amis\Form\InputStatic;
use Edith\Admin\Components\Amis\Form\Select;
use Edith\Admin\Components\Amis\Grid;
use Edith\Admin\Components\Amis\Page;
use Edith\Admin\Events\UploadAfter;
use Edith\Admin\Events\UploadBefore;
use Edith\Admin\Exceptions\RendererException;
use Edith\Admin\Exceptions\ServiceException;
use Edith\Admin\Facades\EdithAdmin;
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

    protected ?string $serviceName = 'Edith\Admin\Services\AttachmentService';

    /**
     * 自定义渲染页面
     * @return Page
     * @throws RendererException
     */
    public function render()
    {
        $page = new Page();
        $page->aside($this->categoryPage());
        $page->body($this->crud(new Crud));
        return $page->asideClassName('category')->css([
            '.category' => [
                'width' => '300px'
            ]
        ])->silentPolling();
    }

    /**
     * @param Crud $crud
     * @return Crud
     * @throws RendererException
     */
    public function crud(Crud $crud): Crud
    {
        $crud->column('category_name', '目录')->width(120);
        $crud->column('name', '附件名称');
        $crud->column('size', '大小')->sortable()->toggled();
        $crud->column('url', '外链')->copyable();
        $crud->column('ext', '扩展名')->sortable();
        $crud->column('preview', '预览')->type('image')->src('${preview}');
        $crud->column('created_at', '上传时间');

        $crud->operation()->rowOnlyDestroyAction();
        $crud->onlyBulkDeleteAction()->basicHeaderToolbar($this->uploadForm())->name('attachment');

        return $crud;
    }

    /**
     * 附件目录浏览
     * @return Crud
     * @throws RendererException
     */
    protected function categoryPage()
    {
        $crud = (new Crud())->perPage(80)->api('api/attachments/category?_action=datasource');
        $crud->column('title', '所属目录');
        $crud->operation()->button('浏览', function(Button $button) {
            $button->actionType('reload')
                ->target('attachment?category_id=${id}')
                ->level('success');
        })->button('删除', function(Button $button) {
            $button->api('delete:api/attachments/category/${id}')
                ->actionType('ajax')
                ->level('danger')
                ->confirmText('请确认是否要删除所选目录？')
                ->visibleOn('${id !== 0}');
        });
        return $crud->basicHeaderToolbar($this->categoryForm(), 'modal', '创建目录')->footerToolbar([]);
    }

    /**
     * 附件目录表单
     * @return Form
     */
    protected function categoryForm()
    {
        $form = (new Form())->api('post:api/attachments/category')->controls([
            (new FormItem('title', '目录名称'))->required(),
        ]);
        return $form;
    }

    /**
     * @return Action
     * @throws RendererException
     */
    protected function uploadForm()
    {
        $action = (new Action)->level('primary')->label('上传附件')->icon('fa-sharp fa-solid fa-cloud-arrow-up');
        $categories = EdithAttachmentCategory::pluck('title as label', 'id as value')->toArray();
        $form = (new Form)->controls([
            (new Select('category_id', '附件目录'))->options(array_merge([['value' => 0, 'label' => '默认目录']], $categories))->value(0),
            (new InputFile())->receiver('api/attachments/upload')
                ->drag()
                ->accept('*')
                ->autoUpload(false)
                ->autoFill([
                    'link' => '${url}'
                ]),
            (new Group())->body([
                new InputStatic('link', '外链地址'),
                (new Button('复制外链地址'))
                    ->icon('fa-sharp fa-solid fa-copy')
                    ->actionType('copy')
                    ->content('${link}')
                    ->visibleOn('${link}')
                    ->columnRatio(2)
            ])
        ]);

        return $action->dialog((new Dialog())->size('lg')->title('上传附件')->body($form)->actions([]));
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

        if($pictureCategoryId) {
            $query->where('category_id',$pictureCategoryId);
        }

        if($pictureSearchName) {
            $query->where('name','like',"%$pictureSearchName%");
        }

        if($pictureSearchDate) {
            $query->whereBetween('created_at', [$pictureSearchDate[0], $pictureSearchDate[1]]);
        }

        $where = null;
        if (EdithAdmin::auth()->platformId()){
            $query->where('platform_id', EdithAdmin::auth()->platformId());
            $where = array('platform_id', EdithAdmin::auth()->platformId());
        }

        $pictures = $query->orderByDesc('id')->paginate(12);

        $pagination = [];
        $data = [];

        if ($pictures) {
            $getPictures = $pictures->toArray();

            $data = $getPictures['data'];

            foreach ($data as $key => $value) {
                $value['path'] = get_attachment($value['id']);
                $data[$key] = $value;
            }

            $pagination['defaultCurrent'] = 1;
            $pagination['current'] = $getPictures['current_page'];
            $pagination['pageSize'] = $getPictures['per_page'];
            $pagination['total'] = $getPictures['total'];
        }

        $categorys = EdithAttachmentCategory::where('obj_type', 'ADMINID')->where($where)->get();

        $attachment['lists'] = $data;
        $attachment['pagination'] = $pagination;
        $attachment['categorys'] = $categorys;

        return success('获取成功！', $attachment);
    }

    /**
     * 上传文件
     * @param Request $request
     * @return JsonResponse
     * @throws ServiceException
     */
    public function upload()
    {
        $platform_id = app('edith.auth')->platformId();
        try {
            $result = $this->service()->upfile($platform_id);
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success('上传成功', $result);
    }
}