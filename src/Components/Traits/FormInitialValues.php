<?php
namespace Edith\Admin\Components\Traits;

use Edith\Admin\Components\Fields\GroupField;
use Edith\Admin\Components\Fields\Item\FormList;
use Edith\Admin\Components\Pages\TabPane;
use Edith\Admin\Components\Pages\Tabs;
use Illuminate\Support\Collection;

trait FormInitialValues
{
    /**
     * @param $tabs
     * @return void
     */
    protected function handleFormFieldValues($tabs): void
    {
        if ($tabs instanceof Tabs) {
            foreach ($tabs->items as $tab) {
                $this->handleFormFieldValues($tab);
            }
        } else if ($tabs instanceof TabPane) {
            $this->handleFormFieldValues($tabs->children);
        } else if ($tabs instanceof Collection || is_array($tabs)) {
            foreach ($tabs as $tab) {
                if ($tab instanceof FormList) {
                    $this->extracted($tab);
                    $this->handleFormFieldValues($tab->items);
                } else if ($tab instanceof TabPane) {
                    $this->handleFormFieldValues($tab);
                } else if ($tab instanceof GroupField) {
                    $this->handleFormFieldValues($tab->body ?? []);
                } else {
                    $this->extracted($tab);
                }
            }
        }
    }

    /**
     * @param $column
     */
    protected function extracted($column): void
    {
        if (!isset($column->dataIndex) && (!isset($column->name) || !is_string($column->name))) {
            return;
        }
        $dataIndex = $column->dataIndex ?? $column->name;
        if (!isset($this->initialValues[$dataIndex]) && isset($column->initialValue)) {
            $this->initialValues[$dataIndex] = $column->initialValue;
        }
        if (isset($column->valueType) || isset($column->renderer)) {
            $valueType = $column->valueType ?? $column->renderer;
            if (isset($this->initialValues[$dataIndex]) && in_array($valueType, ['radio', 'tree', 'select'])) {
                $this->initialValues[$dataIndex] = strval($this->initialValues[$dataIndex]);
            }
            if (isset($this->initialValues[$dataIndex]) && $valueType == 'switch') {
                $this->initialValues[$dataIndex] = $this->initialValues[$dataIndex] == 1 || $this->initialValues[$dataIndex] == 'open';
            }
            if (!empty($this->initialValues[$dataIndex]) && in_array($valueType, ['upload', 'uploader'])) {
                $value = [];
                if (is_string($this->initialValues[$dataIndex]) || is_numeric($this->initialValues[$dataIndex])) {
                    if ($attachment = get_attachment($this->initialValues[$dataIndex], 'all'))
                        $value[] = $attachment;
                } else {
                    foreach ($this->initialValues[$dataIndex] as $row) {
                        if (!$row) {
                            continue;
                        }
                        if (is_string($row)) {
                            $attachment = get_attachment($row, 'all');
                            if ($attachment) {
                                $value[] = $attachment;
                            }
                        } else {
                            $value[] = $row;
                        }
                    }
                }
                $this->initialValues[$dataIndex] = $value;
            }
        }
        unset($column->initialValue);
    }
}