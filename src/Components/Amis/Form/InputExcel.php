<?php
namespace Edith\Admin\Components\Amis\Form;

use Edith\Admin\Exceptions\RendererException;

/**
 * Amis Form InputExcel 解析 Excel
 * 这个组件是通过前端对 Excel 进行解析，将结果作为表单项，使用它有两个好处：
 * 1.节省后端开发成本，无需再次解析 Excel
 * 2.可以前端实时预览效果，比如配合 input-table 组件进行二次修改
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class InputExcel extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-excel';

    /**
     * 是否解析所有 sheet
     * @default false
     * @param bool $allSheets
     * @return InputExcel
     */
    public function allSheets(bool $allSheets = true): InputExcel
    {
        return $this->set('allSheets', $allSheets);
    }

    /**
     * 解析模式
     * @default object
     * @param string $parseMode array | object
     * @return InputExcel
     * @throws RendererException
     */
    public function parseMode(string $parseMode): InputExcel
    {
        if (!in_array($parseMode, ['array', 'object'])) {
            throw new RendererException("Parse mode only supports array or object");
        }
        return $this->set('parseMode', $parseMode);
    }

    /**
     * 是否包含空值
     * @default true
     * @param bool $includeEmpty
     * @return InputExcel
     */
    public function includeEmpty(bool $includeEmpty = true): InputExcel
    {
        return $this->set('includeEmpty', $includeEmpty);
    }

    /**
     * 是否解析为纯文本
     * @default true
     * @param bool $plainText
     * @return InputExcel
     */
    public function plainText(bool $plainText = true): InputExcel
    {
        return $this->set('plainText', $plainText);
    }
}