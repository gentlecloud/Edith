<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis InputTable 表格
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-table
 * @method $this addApi($addApi)                         新增时提交的 API string | API
 * @method $this footerAddBtn($footerAddBtn)             底部新增按钮配置
 * @method $this updateApi($updateApi)                   修改时提交的 API string | API
 * @method $this deleteApi($deleteApi)                   删除时提交的 API string | API
 * @method $this addBtnLabel(string $addBtnLabel)        增加按钮名称
 * @method $this addBtnIcon(string $addBtnIcon)          增加按钮图标 默认： 'plus'
 * @method $this copyBtnLabel(string $copyBtnLabel)      复制按钮文字
 * @method $this copyBtnIcon(string $copyBtnIcon)        复制按钮图标 默认： 'copy'
 * @method $this editBtnLabel(string $editBtnLabel)      编辑按钮名称
 * @method $this editBtnIcon(string $editBtnIcon)        编辑按钮图标 默认： 'pencil'
 * @method $this deleteBtnLabel(string $deleteBtnLabel)  删除按钮名称
 * @method $this deleteBtnIcon(string $deleteBtnIcon)    删除按钮图标 默认： 'minus'
 * @method $this confirmBtnLabel(string $confirmBtnLabel)确认编辑按钮名称
 * @method $this confirmBtnIcon(string $confirmBtnIcon)  确认编辑按钮图标 默认： 'check'
 * @method $this cancelBtnLabel(string $cancelBtnLabel)  取消编辑按钮名称
 * @method $this cancelBtnIcon(string $cancelBtnIcon)    取消编辑按钮图标 默认： 'times'
 * @method $this minLength($minLength)                   最小行数, 支持变量 默认 0
 * @method $this maxLength($maxLength)                   最大行数, 支持变量 默认 Infinity
 * @method $this perPage(int $perPage)                   每页展示几行数据，如果不配置则不会显示分页器
 * @method $this columns(array $columns)                 列信息
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class InputTable extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-table';

    /**
     * 是否可增加一行
     * @default false
     * @param bool $addable
     * @return InputTable
     */
    public function addable(bool $addable = true): InputTable
    {
        return $this->set('addable', $addable);
    }

    /**
     * 是否可编辑
     * @default false
     * @param bool $editable
     * @return InputTable
     */
    public function editable(bool $editable = true): InputTable
    {
        return $this->set('editable', $editable);
    }

    /**
     * 是否可删除
     * @default false
     * @param bool $removable
     * @return InputTable
     */
    public function removable(bool $removable = true): InputTable
    {
        return $this->set('removable', $removable);
    }

    /**
     * 是否显示表格操作栏添加按钮
     * @default true
     * @param bool $showTableAddBtn
     * @return InputTable
     */
    public function showTableAddBtn(bool $showTableAddBtn = true): InputTable
    {
        return $this->set('showTableAddBtn', $showTableAddBtn);
    }

    /**
     * 是否显示表格下方添加按钮
     * @default true
     * @param bool $showFooterAddBtn
     * @return InputTable
     */
    public function showFooterAddBtn(bool $showFooterAddBtn = true): InputTable
    {
        return $this->set('showFooterAddBtn', $showFooterAddBtn);
    }

    /**
     * 是否需要确认操作，，可用来控控制表格的操作交互
     * @default true
     * @param bool $needConfirm
     * @return InputTable
     */
    public function needConfirm(bool $needConfirm = true): InputTable
    {
        return $this->set('needConfirm', $needConfirm);
    }

    /**
     * 是否可以访问父级数据，也就是表单中的同级数据，通常需要跟 strictMode 搭配使用
     * @default false
     * @param bool $canAccessSuperData
     * @return InputTable
     */
    public function canAccessSuperData(bool $canAccessSuperData = true): InputTable
    {
        return $this->set('canAccessSuperData', $canAccessSuperData);
    }

    /**
     * 为了性能，默认其他表单项项值变化不会让当前表格更新，有时候为了同步获取其他表单项字段，需要开启这个。
     * @default true
     * @param bool $strictMode
     * @return InputTable
     */
    public function strictMode(bool $strictMode = true): InputTable
    {
        return $this->set('strictMode', $strictMode);
    }
}