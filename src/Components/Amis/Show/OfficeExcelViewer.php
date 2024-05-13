<?php
namespace Gentle\Edith\Components\Amis\Show;

/**
 * Amis OfficeViewer Excel 阅读器
 * @author Chico
 * @company Xiamen Gentle Technology Co., Ltd
 */
class OfficeExcelViewer extends OfficeViewer
{
    /**
     * @var array
     */
    protected array $excelOptions = [];

    /**
     * 是否显示公式拦
     * @default true
     * @param bool $showFormulaBar
     * @return $this
     */
    public function showFormulaBar(bool $showFormulaBar = true): OfficeExcelViewer
    {
        $this->excelOptions['showFormulaBar'] = $showFormulaBar;
        return $this;
    }

    /**
     * 是否显示底部 sheet 切换
     * @default true
     * @param bool $showSheetTabBar
     * @return $this
     */
    public function showSheetTabBar(bool $showSheetTabBar = true): OfficeExcelViewer
    {
        $this->excelOptions['showSheetTabBar'] = $showSheetTabBar;
        return $this;
    }

    /**
     * 字体配置
     * @param array $fontURL
     * @return $this
     */
    public function fontURL(array $fontURL): OfficeExcelViewer
    {
        $this->excelOptions['fontURL'] = $fontURL;
        return $this;
    }
}