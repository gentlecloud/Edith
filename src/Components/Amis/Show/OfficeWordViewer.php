<?php
namespace Edith\Admin\Components\Amis\Show;

/**
 * Amis OfficeViewer Word 阅读器
 * @author Chico
 * @company Xiamen Gentle Technology Co., Ltd
 */
class OfficeWordViewer extends OfficeViewer
{
    /**
     * @var array
     */
    protected array $wordOptions = [
        'classPrefix' => 'docx-viewer',
        'padding' => '8px',
        'ignoreWidth' => false,
        'printOptions' => [
            'page' => true,
            'pageWrap' => false,
            'pageShadow' => false,
            'pageMarginBottom' => 0,
            'pageWrapPadding' => null
        ]
    ];

    public function classPrefix(string $classPrefix): OfficeWordViewer
    {
        $this->wordOptions['classPrefix'] = $classPrefix;
        return $this;
    }

    /**
     * 忽略文档里的宽度设置，用于更好嵌入到页面里，但会减低还原度
     * @default false
     * @param bool $ignoreWidth
     * @return $this
     */
    public function ignoreWidth(bool $ignoreWidth): OfficeWordViewer
    {
        $this->wordOptions['ignoreWidth'] = $ignoreWidth;
        return $this;
    }

    /**
     * 设置页面间距，忽略文档中的设置
     * @param string $padding
     * @return $this
     */
    public function padding(string $padding): OfficeWordViewer
    {
        $this->wordOptions['padding'] = $padding;
        return $this;
    }

    /**
     * 列表使用字体渲染，请参考下面的乱码说明
     * @default true
     * @param bool $bulletUseFont
     * @return $this
     */
    public function bulletUseFont(bool $bulletUseFont = true): OfficeWordViewer
    {
        $this->wordOptions['bulletUseFont'] = $bulletUseFont;
        return $this;
    }

    /**
     * 字体映射，是个键值对，用于替换文档中的字体
     * @param array $fontMapping
     * @return $this
     */
    public function fontMapping(array $fontMapping): OfficeWordViewer
    {
        $this->wordOptions['fontMapping'] = $fontMapping;
        return $this;
    }

    /**
     * 设置段落行高，忽略文档中的设置
     * @param string $forceLineHeight
     * @return $this
     */
    public function forceLineHeight(string $forceLineHeight): OfficeWordViewer
    {
        $this->wordOptions['forceLineHeight'] = $forceLineHeight;
        return $this;
    }

    /**
     * 是否开启变量替换功能
     * @default true
     * @param bool $enableVar
     * @return $this
     */
    public function enableVar(bool $enableVar = true): OfficeWordViewer
    {
        $this->wordOptions['enableVar'] = $enableVar;
        return $this;
    }

    /**
     * 针对打印的特殊设置，可以覆盖其它所有设置项
     * @param array $printOptions
     * @return OfficeWordViewer
     */
    public function printOptions(array $printOptions): OfficeWordViewer
    {
        $this->wordOptions['printOptions'] = $printOptions;
        return $this;
    }

    /**
     * 是否开启分页渲染
     * @default false
     * @param bool $page
     * @return $this
     */
    public function page(bool $page = true): OfficeWordViewer
    {
        $this->wordOptions['page'] = $page;
        return $this;
    }

    /**
     * 页面上下间距
     * @default 20
     * @param int $pageMarginBottom
     * @return $this
     */
    public function pageMarginBottom(int $pageMarginBottom): OfficeWordViewer
    {
        $this->wordOptions['pageMarginBottom'] = $pageMarginBottom;
        return $this;
    }

    /**
     * 页面内背景色
     * @default #fff
     * @param string $pageBackground
     * @return $this
     */
    public function pageBackground(string $pageBackground): OfficeWordViewer
    {
        $this->wordOptions['pageBackground'] = $pageBackground;
        return $this;
    }

    /**
     * 是否显示阴影
     * @default true
     * @param bool $pageShadow
     * @return OfficeWordViewer
     */
    public function pageShadow(bool $pageShadow = true): OfficeWordViewer
    {
        $this->wordOptions['pageShadow'] = $pageShadow;
        return $this;
    }

    /**
     * 是否显示页面包裹
     * @default true
     * @param bool $pageWrap
     * @return $this
     */
    public function pageWrap(bool $pageWrap = true): OfficeWordViewer
    {
        $this->wordOptions['pageWrap'] = $pageWrap;
        return $this;
    }

    /**
     * 页面包裹的背景色
     * @default #ECECEC
     * @param string $color
     * @return OfficeWordViewer
     */
    public function pageWrapBackground(string $color): OfficeWordViewer
    {
        $this->wordOptions['pageWrapBackground'] = $color;
        return $this;
    }

    /**
     * 缩放比例，取值 0-1 之间
     * @param float $zoom
     * @return $this
     */
    public function zoom(float $zoom): OfficeWordViewer
    {
        $this->wordOptions['zoom'] = $zoom;
        return $this;
    }

    /**
     * 自适应宽度缩放，如果设置了 zoom 将不会生效
     * @default false
     * @param bool $zoomFitWidth
     * @return $this
     */
    public function zoomFitWidth(bool $zoomFitWidth): OfficeWordViewer
    {
        $this->wordOptions['zoomFitWidth'] = $zoomFitWidth;
        return $this;
    }
}