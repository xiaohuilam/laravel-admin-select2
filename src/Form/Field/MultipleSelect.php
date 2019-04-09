<?php
namespace LaravelAdminExt\Select2\Form\Field;

use Encore\Admin\Form\Field\MultipleSelect as BaseMultipleSelect;
use LaravelAdminExt\Select2\Traits\Select2Trait;
use LaravelAdminExt\Select2\Traits\FormTrait;

class MultipleSelect extends BaseMultipleSelect
{
    protected $withId = 0;
    protected $ajax_appends = [];
    protected $view = 'laravel-admin-select2::multiple_select';

    use Select2Trait, FormTrait;
}
