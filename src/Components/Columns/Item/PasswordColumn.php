<?php
namespace Edith\Admin\Components\Columns\Item;

use Edith\Admin\Components\Columns\Column;

class PasswordColumn extends Column
{

    public function __construct(?string $dataIndex = null, ?string $title = null)
    {
        parent::__construct($dataIndex, $title, 'password');
    }

    /**
     * 是否显示切换按钮或者控制密码显隐	boolean | { visible: boolean }
     * @param bool|array $visibility
     * @return self
     */
    public function visibilityToggle(bool|array $visibility): self
    {
        return $this->fieldProp('visibilityToggle', $visibility);
    }
}