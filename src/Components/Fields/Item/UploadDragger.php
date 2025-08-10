<?php
namespace Edith\Admin\Components\Fields\Item;

class UploadDragger extends Upload
{
    /**
     * @var string
     */
    public string $component = 'upload-dragger';

    /**
     * Dragger 的描述
     * @param string $description
     * @return self
     */
    public function description(string $description): self
    {
        return $this->set('description', $description);
    }
}