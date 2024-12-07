<?php
namespace Edith\Admin\Components\Amis\Form;

use Edith\Admin\Components\Amis\AmisRenderer;
use Edith\Admin\Exceptions\RendererException;
use Illuminate\Support\Collection;

/**
 * Amis Form
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/index
 * @method $this name(string $name)                                  设置一个名字后，方便其他组件与其通信
 * @method $this horizontal(array $horizontal)                       当 mode 为 horizontal 时有用，用来控制 label 默认值: {"left":"col-sm-2", "right":"col-sm-10", "offset":"col-sm-offset-2"}
 * @method $this labelWidth($labelWidth)                             表单项标签自定义宽度 string | number
 * @method $this title(string $title)                                Form 的标题 默认： 表单
 * @method $this submitText(string $submitText)                      默认的提交按钮名称，如果设置成空，则可以把默认按钮去掉。
 * @method $this actions(array $actions)                             Form 提交按钮，成员为 Action
 * @method $this messages(array $messages)                           消息提示覆写，默认消息读取的是 API 返回的消息，但是在此可以覆写它。
 * @method $this panelClassName(string $panelClassName)              外层 panel 的类名
 * @method $this api($api)                                           Form 用来保存数据的 api。
 * @method $this initApi($initApi)                                   Form 用来获取初始数据的 api。
 * @method $this rules(array $rules)                                 表单组合校验规则  Array<{rule:string;message:string}>
 * @method $this interval(int $interval)                             刷新时间(最低 3000)
 * @method $this stopAutoRefreshWhen(string $stopAutoRefreshWhen)    通过表达式 来配置停止刷新的条件
 * @method $this initAsyncApi($initAsyncApi)                         Form 用来获取初始数据的 api,与 initApi 不同的是，会一直轮询请求该接口，直到返回 finished 属性为 true 才 结束。
 * @method $this initFetchOn(string $initFetchOn)                    用表达式来配置
 * @method $this initFinishedField(string $initFinishedField)        设置了 initAsyncApi 后，默认会从返回数据的 data.finished 来判断是否完成，也可以设置成其他的 xxx，就会从 data.xxx 中获取
 * @method $this initCheckInterval(int $initCheckInterval)           设置了 initAsyncApi 以后，默认拉取的时间间隔
 * @method $this asyncApi($asyncApi)                                 设置此属性后，表单提交发送保存接口后，还会继续轮询请求该接口，直到返回 finished 属性为 true 才 结束。
 * @method $this checkInterval(int $checkInterval)                   轮询请求的时间间隔，默认为 3 秒。设置 asyncApi 才有效
 * @method $this finishedField(string $finishedField)                如果决定结束的字段名不是 finished 请设置此属性，比如 is_success
 * @method $this primaryField(string $primaryField)                  设置主键 id, 当设置后，检测表单是否完成时（asyncApi），只会携带此数据。
 * @method $this target(string $target)                              默认表单提交自己会通过发送 api 保存数据，但是也可以设定另外一个 form 的 name 值，或者另外一个 CRUD 模型的 name 值。 如果 target 目标是一个 Form ，则目标 Form 会重新触发 initApi，api 可以拿到当前 form 数据。如果目标是一个 CRUD 模型，则目标模型会重新触发搜索，参数为当前 Form 数据。当目标是 window 时，会把当前表单的数据附带到页面地址上。
 * @method $this redirect(string $redirect)                          设置此属性后，Form 保存成功后，自动跳转到指定页面。支持相对地址，和绝对地址（相对于组内的）。
 * @method $this reload(string $reload)                              操作完后刷新目标对象。请填写目标组件设置的 name 值，如果填写为 window 则让当前页面整体刷新。
 * @method $this persistData(string $persistData)                    指定一个唯一的 key，来配置当前表单是否开启本地缓存
 * @method $this persistDataKeys(array $persistDataKeys)             指指定只有哪些 key 缓存 string[]
 * @method $this columnCount(int $columnCount)                       表单项显示为几列 默认： 0
 * @method $this staticClassName(string $staticClassName)            表单静态展示时使用的类名
 * @method $this static(bool $static)                                整个表单静态方式展示，详情请查看 https://aisuda.bce.baidu.com/amis/examples/form/switchDisplay
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Form extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'form';

    /**
     * 表单标题
     * @var string
     */
    protected string $title = "";

    /**
     * 表单列
     * @var Collection|array
     */
    protected $controls;

    /**
     * construct Form
     */
    public function __construct()
    {
        parent::__construct();
        $this->controls = new Collection();
    }

    /**
     * @param string $mode
     * @return Form
     * @throws \Exception
     */
    public function mode(string $mode): Form
    {
        if (!in_array($mode, ['normal', 'horizontal', 'inline'])) {
            throw new \Exception("Form mode only supports setting 'normal', 'horizontal', 'inline'");
        }
        return $this->set('mode', $mode);
    }

    /**
     * 表单项标签对齐方式，默认右对齐，仅在 mode为horizontal 时生效
     * @param string $labelAlign left | right
     * @default right
     * @return Form
     * @throws RendererException
     */
    public function labelAlign(string $labelAlign): Form
    {
        if (!in_array($labelAlign, ['left', 'right'])) {
            throw new RendererException("Form label align only supports left or right");
        }
        return $this->set('labelAlign', $labelAlign);
    }

    /**
     * 是否让 Form 用 panel 包起来，设置为 false 后，actions 将无效。
     * @default true
     * @param bool $wrapWithPanel
     * @return Form
     */
    public function wrapWithPanel(bool $wrapWithPanel = true): Form
    {
        return $this->set('wrapWithPanel', $wrapWithPanel);
    }

    /**
     * 配置刷新时是否显示加载动画
     * @default false
     * @param $silentPolling
     * @return Form
     */
    public function silentPolling($silentPolling = true): Form
    {
        return $this->set('silentPolling', $silentPolling);
    }

    /**
     * 设置了 initApi 或者 initAsyncApi 后，默认会开始就发请求，设置为 false 后就不会起始就请求接口
     * @default true
     * @param bool $initFetch
     * @return Form
     */
    public function initFetch(bool $initFetch = true): Form
    {
        return $this->set('initFetch', $initFetch);
    }

    /**
     * 表单修改即提交
     * @default false
     * @param bool $submitOnChange
     * @return Form
     */
    public function submitOnChange(bool $submitOnChange = true): Form
    {
        return $this->set('submitOnChange', $submitOnChange);
    }

    /**
     * 初始就提交一次
     * @default false
     * @param bool $submitOnInit
     * @return Form
     */
    public function submitOnInit(bool $submitOnInit = true): Form
    {
        return $this->set('submitOnInit', $submitOnInit);
    }

    /**
     * 提交后是否重置表单
     * @default false
     * @param bool $resetAfterSubmit
     * @return Form
     */
    public function resetAfterSubmit(bool $resetAfterSubmit = true): Form
    {
        return $this->set('resetAfterSubmit', $resetAfterSubmit);
    }

    /**
     * 是否自动聚焦。
     * @default false
     * @param bool $autoFocus
     * @return Form
     */
    public function autoFocus(bool $autoFocus = true): Form
    {
        return $this->set('autoFocus', $autoFocus);
    }

    /**
     * 指定是否可以自动获取上层的数据并映射到表单项上
     * @default true
     * @param bool $canAccessSuperData
     * @return Form
     */
    public function canAccessSuperData(bool $canAccessSuperData = true): Form
    {
        return $this->set('canAccessSuperData', $canAccessSuperData);
    }

    /**
     * 指定表单提交成功后是否清除本地缓存
     * @default true
     * @param bool $clearPersistDataAfterSubmit
     * @return Form
     */
    public function clearPersistDataAfterSubmit(bool $clearPersistDataAfterSubmit = true): Form
    {
        return $this->set('clearPersistDataAfterSubmit', $clearPersistDataAfterSubmit);
    }

    /**
     * 禁用回车提交表单
     * @default false
     * @param bool $preventEnterSubmit
     * @return Form
     */
    public function preventEnterSubmit(bool $preventEnterSubmit = true): Form
    {
        return $this->set('preventEnterSubmit', $preventEnterSubmit);
    }

    /**
     * trim 当前表单项的每一个值
     * @default false
     * @param bool $trimValues
     * @return Form
     */
    public function trimValues(bool $trimValues = true): Form
    {
        return $this->set('trimValues', $trimValues);
    }

    /**
     * form 还没保存，即将离开页面前是否弹框确认。
     * @default false
     * @param bool $promptPageLeave
     * @return Form
     */
    public function promptPageLeave(bool $promptPageLeave = true): Form
    {
        return $this->set('promptPageLeave', $promptPageLeave);
    }

    /**
     * 默认表单是采用数据链的形式创建个自己的数据域，表单提交的时候只会发送自己这个数据域的数据，如果希望共用上层数据域可以设置这个属性为 false，这样上层数据域的数据不需要在表单中用隐藏域或者显式映射才能发送了。
     * @default true
     * @param bool $inheritData
     * @return Form
     */
    public function inheritData(bool $inheritData = true): Form
    {
        return $this->set('inheritData', $inheritData);
    }

    /**
     * Form 表单项集合
     * @param Collection|array|object $controls
     * @return Form
     */
    public function controls($controls)
    {
        if (!($controls instanceof Collection)) {
            $controls = new Collection($controls);
        }
        return $this->set('controls', $controls);
    }

    /**
     * @param $data
     * @return Form
     */
    public function initialValues($data)
    {
        return $this->set('data', $data);
    }

    /**
     * @param string|null $field
     * @param string|null $label
     * @return FormItem
     */
    public function item(?string $field = null, ?string $label = null): FormItem
    {
        return tap(new FormItem($field, $label), function ($value) {
            $this->controls->push($value);
        });
    }

    /**
     * 渲染 Form
     * @return array
     */
    public function render(): array
    {
        if (!isset($this->api)) {
            if (isset($this->data['id'])) {
                $this->set('api', 'put:' . url()->current());
            } else {
                $this->set('api', 'post:' . url()->current());
            }
        }
        return parent::render(); // TODO: Change the autogenerated stub
    }
}