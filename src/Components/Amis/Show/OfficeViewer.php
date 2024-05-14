<?php
namespace Edith\Admin\Components\Amis\Show;

use Edith\Admin\Components\Amis\Action\Action;
use Edith\Admin\Components\Amis\AmisRenderer;
use Edith\Admin\Components\Amis\Form\InputFile;

/**
 * Amis OfficeViewer Office 文件阅读器
 * 参考文档：https://aisuda.bce.baidu.com/amis/zh-CN/components/office-viewer
 * @method $this src(string $src)                                 Office 文件地址
 * @method $this wordOptions(array $wordOptions)                  Word 配置 https://aisuda.bce.baidu.com/amis/zh-CN/components/office-viewer#word-%E6%B8%B2%E6%9F%93%E9%85%8D%E7%BD%AE%E5%B1%9E%E6%80%A7%E8%A1%A8
 * @method $this printOptions(array $printOptions)                可以用来自定义在打印时的配置
 * @method $this excelOptions(array $excelOptions)                Excel 配置 https://aisuda.bce.baidu.com/amis/zh-CN/components/office-viewer-excel
 * @method $this display(bool $display)                           false 可以让文档不渲染，虽然不渲染，但还是可以使用后面的下载及打印功能
 */
class OfficeViewer extends AmisRenderer
{
    /**
     * @var string
     */
    protected string $type = 'office-viewer';

    /**
     * 是否打印文档
     * @var bool
     */
    protected bool $print = false;

    /**
     * 是否下载文档
     * @var bool
     */
    protected bool $download = false;

    /**
     * 上传文档预览
     * @var bool
     */
    protected bool $upfile = false;

    /**
     * 是否显示 loading 图标
     * @default false
     * @param bool $loading
     * @return OfficeViewer
     */
    public function loading(bool $loading = true): OfficeViewer
    {
        return $this->set('loading', $loading);
    }

    /**
     * 是否开启变量替换功能
     * @param bool $enable
     * @return OfficeViewer
     */
    public function enableVar(bool $enable): OfficeViewer
    {
        return $this->set('enableVar', $enable);
    }

    /**
     * 打印文档
     * @param bool $display 是否渲染文档。默认不渲染
     * @return OfficeViewer
     */
    public function print(bool $display = false)
    {
        $this->set('display', $display);
        return $this->set('print', true);
    }

    /**
     * 下载文档
     * @param bool $display 是否渲染文档。默认不渲染
     * @return OfficeViewer
     */
    public function download(bool $display = false)
    {
        $this->set('display', $display);
        return $this->set('download', true);
    }

    /**
     * 上传文档饼实现预览功能
     * @param bool $display 是否渲染预览文档。默认不渲染
     * @return OfficeViewer
     */
    public function upfile(bool $display = false)
    {
        $this->set('display', $display);
        return $this->set('upfile', true);
    }

    /**
     * 自定渲染
     * @return array
     */
    public function render(): array
    {
        $renderer = [];
        if (!isset($this->id)) {
            $this->id('office-viewer-' . $this->uniqid);
        }
        // 处理打印文档按钮
        if ($this->print) {
            $renderer[] = (new Action)->label('打印文档')->icon('fa fa-print')->onClick([
                'actionType' => 'print',
                'componentId' => $this->id
            ]);
        }
        // 处理下载文档按钮
        if ($this->download) {
            $renderer[] = (new Action)->label('下载文档')->icon('fa fa-download')->onClick([
                'actionType' => 'saveAs',
                'componentId' => $this->id
            ]);
        }
        // 处理上传文档按钮
        if ($this->upfile) {
            if (!isset($this->name)) {
                $this->name('file');
            }
            $renderer[] = (new InputFile($this->name, '上传文档'))->asBlob()->accept('.docx');
        }
        // 返回渲染
        $renderer[] = parent::render();
        return $renderer;
    }
}