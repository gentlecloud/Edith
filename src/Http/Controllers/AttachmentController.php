<?php
namespace Gentle\Edith\Http\Controllers;

use Gentle\Edith\Components\Amis\Action\Action;
use Gentle\Edith\Components\Amis\Action\Button;
use Gentle\Edith\Components\Amis\Action\Dialog;
use Gentle\Edith\Components\Amis\Crud;
use Gentle\Edith\Components\Amis\Form\Form;
use Gentle\Edith\Components\Amis\Form\FormItem;
use Gentle\Edith\Components\Amis\Form\Group;
use Gentle\Edith\Components\Amis\Form\InputFile;
use Gentle\Edith\Components\Amis\Form\InputStatic;
use Gentle\Edith\Components\Amis\Form\Select;
use Gentle\Edith\Components\Amis\Grid;
use Gentle\Edith\Events\UploadAfter;
use Gentle\Edith\Events\UploadBefore;
use Gentle\Edith\Exceptions\RendererException;
use Gentle\Edith\Exceptions\ServiceException;
use Gentle\Edith\Models\EdithAttachment;
use Gentle\Edith\Models\EdithAttachmentCategory;
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
     * 控制器模型
     * @var string|null
     */
    protected ?string $modelName = "Gentle\Edith\Models\EdithAttachment";

    /**
     * @param Crud $crud
     * @return Crud
     * @throws RendererException
     */
    public function crud(Crud $crud): Crud
    {
        $categories = EdithAttachmentCategory::pluck('id as value', 'title as label')->toArray();
        $categories = array_merge([[ 'value' => 0, 'label' => '未分类' ]], $categories);
        $crud->column('category_name', '目录')->width(120)->searchable('select', '选择附件目录', $categories);
        $crud->column('name', '附件名称');
        $crud->column('size', '大小')->sortable()->toggled();
        $crud->column('url', '外链')->copyable();
        $crud->column('ext', '扩展名')->sortable();
        $crud->column('preview', '预览')->type('image')->src('${preview}');
        $crud->column('created_at', '上传时间');

        $crud->operation()->rowOnlyDestroyAction();
        $crud->onlyBulkDeleteAction()->basicHeaderToolbar($this->uploadForm());

        return $crud;
    }

    protected function uploadForm()
    {
        $action = (new Action)->level('primary')->label('上传附件')->icon('fa-sharp fa-solid fa-cloud-arrow-up');
        $categories = EdithAttachmentCategory::pluck('title as label', 'id as value')->toArray();
        $form = (new Form)->controls([
            (new Select('category_id', '附件目录'))->options(array_merge([['value' => 0, 'label' => '默认目录']], $categories))->value(0),
            (new InputFile())->receiver('api/attachment/upload')
                ->drag()
                ->accept('*')
                ->autoUpload(false)
                ->autoFill([
                    'link' => '${url}'
                ]),
            (new Group())->body([
                new InputStatic('link', '外链地址'),
                (new Button('复制外链地址'))->icon('fa-sharp fa-solid fa-copy')->actionType('copy')->content('${link}')->visibleOn('${link}')->columnRatio(2)
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

        $query = EdithAttachment::query();

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
        if (app('edith.platform')->id()){
            $query->where('platform_id', app('edith.platform')->id());
            $where = array('platform_id', app('edith.platform')->id());
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
    public function upload(Request $request)
    {
        $platform_id = app('edith.auth')->platformId();
        $before = new UploadBefore($request, $platform_id);
        event($before); // 执行上传前事件，

        if (!($file = $before->file)) { // 如无工具模块事件存储文件 进行本地上传
            $file = $this->localUpload($request, $platform_id);
        }
        if (!isset($file['path']) && !isset($file['url'])) {
            return error('上传失败');
        }

        if (!isset($file['id'])) { // 如果不存在模型索引ID 执行上传后事件
            $after = new UploadAfter($request, $file);
            event($after);
            $result = [
                'id' => $after->fileId,
                'url' => $file['url'] ?? $file['path'],
                'size' => $file['size'],
                'name' => $file['name'],
//                'path' => $file['path']
            ];
        } else {
            $result = $file;
        }
        return success('上传成功', $result);
    }

    /**
     * 本地上传图片
     * @param Request $request
     * @param int $platformId
     * @return array
     * @throws \Gentle\Edith\Exceptions\ServiceException
     */
    protected function localUpload(Request $request, int $platformId = 0): array
    {
        $file = $request->file('file');
        $md5 = md5_file($file->getRealPath());
        $name = $file->getClientOriginalName();

        $hasPicture = $this->service()->query()->where('md5', $md5)->first();

        // 不存在文件，则插入数据库
        if (!$hasPicture) {
            $path = $file->store('public/uploads/attachments');
            // 获取文件大小
            $size = Storage::size($path);

            // 数据
            $data = [
                'obj_id' => $platformId,
                'name' => $name,
                'size' => $size,
                'md5' => $md5,
                'ext' => $file->getClientOriginalExtension(),
                'upload_ip' => $request->ip(),
                'path' => $path,
                'url' => asset(Storage::url($path))
            ];
        } else {
            if (str_contains($hasPicture->path,'http')) {
                $url = $hasPicture->path;
            } else {
                // 获取文件url，用于外部访问
                $url = Storage::url($hasPicture->path);
            }

            $data = [
                'id' => $hasPicture->id,
                'name' => $name,
                'url' => asset($url),
//                'path' => $hasPicture->path,
                'size' => $hasPicture->size
            ];
        }

        // 返回数据
        return $data;
    }
}