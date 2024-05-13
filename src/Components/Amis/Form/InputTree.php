<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis InputTree 树形选择框
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-tree
 * @method $this options(array $options)                                  选项组
 * @method $this source($source)                                          动态选项组 string | API
 * @method $this autoComplete($autoComplete)                              自动提示补全 string | API
 * @method $this delimeter(string $delimeter)                             拼接符
 * @method $this labelField(string $labelField)                           选项标签字段 默认: label
 * @method $this valueField(string $valueField)                           选项值字段 默认: value
 * @method $this iconField(string $iconField)                             图标值字段 默认: icon
 * @method $this addControls(array $addControls)                          自定义新增表单项
 * @method $this addApi(string $addApi)                                   配置新增选项接口
 * @method $this editControls(array $editControls)                        自定义编辑表单项
 * @method $this editApi(string $editApi)                                 配置编辑选项接口
 * @method $this deleteApi(string $deleteApi)                             配置删除选项接口
 * @method $this rootLabel(string $rootLabel)                             当 hideRoot 不为 false 时有用，用来设置顶级节点的文字。
 * @method $this unfoldedLevel(int $unfoldedLevel)                        设置默认展开的级数，只有initiallyOpen不是true时生效。
 * @method $this rootCreateTip(string $rootCreateTip)                     创建顶级节点的悬浮提示 默认： "添加一级节点"
 * @method $this minLength(int $minLength)                                最少选中的节点数
 * @method $this maxLength(int $maxLength)                                最多选中的节点数
 * @method $this treeContainerClassName(string $treeContainerClassName)   tree 最外层容器类名
 * @method $this pathSeparator(string $pathSeparator)                     节点路径的分隔符，enableNodePath为true时生效 默认： "/"
 * @method $this highlightTxt(string $highlightTxt)                       标签中需要高亮的字符，支持变量
 * @method $this itemHeight(int $itemHeight)                              每个选项的高度，用于虚拟渲染 默认： 32
 * @method $this virtualThreshold(int $virtualThreshold)                  在选项数量超过多少时开启虚拟渲染 默认： 100
 * @method $this menuTpl(string $menuTpl)                                 选项自定义渲染 HTML 片段
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class InputTree extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'tree';

    /**
     * 是否提取值
     * @var bool
     */
    protected bool $extractValue = true;

    /**
     * 是否拼接值，拼接后 array 将拼接 string
     * @var bool
     */
    protected bool $joinValues = false;

    /**
     * 是否多选
     * @param bool $multiple
     * @default false
     * @return InputTree
     */
    public function multiple(bool $multiple = true): InputTree
    {
        return $this->set('multiple', $multiple);
    }

    /***
     * 拼接值
     * @param bool $joinValues
     * @default true
     * @return InputTree
     */
    public function joinValues(bool $joinValues = false): InputTree
    {
        return $this->set('joinValues', $joinValues);
    }

    /**
     * 提取值
     * @param bool $extractValue
     * @default false
     * @return InputTree
     */
    public function extractValue(bool $extractValue = true): InputTree
    {
        return $this->set('extractValue', $extractValue);
    }

    /**
     * 新增选项
     * @param bool $creatable
     * @default false
     * @return InputTree
     */
    public function creatable(bool $creatable = true): InputTree
    {
        return $this->set('creatable', $creatable);
    }

    /**+
     * 编辑选项
     * @param bool $editable
     * @default false
     * @return InputTree
     */
    public function editable(bool $editable = true): InputTree
    {
        return $this->set('editable', $editable);
    }

    /**
     * 删除选项
     * @param bool $removable
     * @default false
     * @return InputTree
     */
    public function removable(bool $removable = true): InputTree
    {
        return $this->set('removable', $removable);
    }

    /**
     * 是否可检索
     * @param bool $searchable
     * @return InputTree
     */
    public function searchable(bool $searchable = true): InputTree
    {
        return $this->set('searchable', $searchable);
    }

    /**
     * 如果想要显示个顶级节点，请设置为 false
     * @default true
     * @param bool $hideRoot
     * @return InputTree
     */
    public function hideRoot(bool $hideRoot = false): InputTree
    {
        return $this->set('hideRoot', $hideRoot);
    }

    /**
     * 是否显示图标
     * @param bool $showIcon
     * @default true
     * @return InputTree
     */
    public function showIcon(bool $showIcon = true): InputTree
    {
        return $this->set('showIcon', $showIcon);
    }

    /**
     * 是否显示单选按钮，multiple 为 false 是有效
     * @default false
     * @param bool $showRadio
     * @return InputTree
     */
    public function showRadio(bool $showRadio = true): InputTree
    {
        return $this->set('showRadio', $showRadio);
    }

    /**
     * 是否显示树层级展开线
     * @default false
     * @param bool $showOutline
     * @return InputTree
     */
    public function showOutline(bool $showOutline = true): InputTree
    {
        return $this->set('showOutline', $showOutline);
    }

    /**
     * 设置是否默认展开所有层级。
     * @default true
     * @param bool $initiallyOpen
     * @return InputTree
     */
    public function initiallyOpen(bool $initiallyOpen = false): InputTree
    {
        return $this->set('initiallyOpen', $initiallyOpen);
    }

    /**
     * 当选中父节点时级联选择子节点。
     * @default true
     * @param bool $autoCheckChildren
     * @return InputTree
     */
    public function autoCheckChildren(bool $autoCheckChildren = true): InputTree
    {
        return $this->set('autoCheckChildren', $autoCheckChildren);
    }

    /**
     * 当选中父节点时不自动选择子节点。
     * @default false
     * @param bool $cascade
     * @return InputTree
     */
    public function cascade(bool $cascade = true): InputTree
    {
        return $this->set('cascade', $cascade);
    }

    /**
     * 选中父节点时，值里面将包含子节点的值，否则只会保留父节点的值。
     * @default false
     * @param bool $withChildren
     * @return InputTree
     */
    public function withChildren(bool $withChildren = true): InputTree
    {
        return $this->set('withChildren', $withChildren);
    }

    /**
     * 多选时，选中父节点时，是否只将其子节点加入到值中。
     * @param bool $onlyChildren
     * @return InputTree
     */
    public function onlyChildren(bool $onlyChildren = true): InputTree
    {
        return $this->set('onlyChildren', $onlyChildren);
    }

    /***
     * 只允许选择叶子节点
     * @default false
     * @param bool $onlyLeaf
     * @return InputTree
     */
    public function onlyLeaf(bool $onlyLeaf = true): InputTree
    {
        return $this->set('onlyLeaf', $onlyLeaf);
    }

    /**
     * 是否可以创建顶级节点
     * @default false
     * @param bool $rootCreatable
     * @return InputTree
     */
    public function rootCreatable(bool $rootCreatable = true): InputTree
    {
        return $this->set('rootCreatable', $rootCreatable);
    }

    /**
     * 是否开启节点路径模式
     * @default false
     * @param bool $enableNodePath
     * @return InputTree
     */
    public function enableNodePath(bool $enableNodePath = true): InputTree
    {
        return $this->set('enableNodePath', $enableNodePath);
    }

    /**
     * 是否为选项添加默认的前缀 Icon，父节点默认为folder，叶节点默认为file
     * @param bool $enableDefaultIcon
     * @return InputTree
     */
    public function enableDefaultIcon(bool $enableDefaultIcon = true): InputTree
    {
        return $this->set('enableDefaultIcon', $enableDefaultIcon);
    }

    /**
     * 默认高度会有个 maxHeight，即超过一定高度就会内部滚动，如果希望自动增长请设置此属性
     * @param bool $heightAuto
     * @return InputTree
     */
    public function heightAuto(bool $heightAuto = true): InputTree
    {
        return $this->set('heightAuto', $heightAuto);
    }
}