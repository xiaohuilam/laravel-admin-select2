<?php

namespace LaravelAdminExt\Select2\Form\Field;

use Encore\Admin\Form\Field\MultipleSelect as BaseMultipleSelect;
use LaravelAdminExt\Select2\Traits\FormTrait;
use LaravelAdminExt\Select2\Traits\Select2Trait;

class MultipleSelect extends BaseMultipleSelect
{
    protected $withId = 0;
    use Select2Trait, FormTrait;

    /**
     * Get view of this field.
     *
     * @return string
     */
    public function getView()
    {
        return 'laravel-admin-select2::multipleselect';
    }
}
