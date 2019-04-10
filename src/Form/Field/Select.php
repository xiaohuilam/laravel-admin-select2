<?php

namespace LaravelAdminExt\Select2\Form\Field;

use Encore\Admin\Form\Field\Select as BaseSelect;
use LaravelAdminExt\Select2\Traits\FormTrait;
use LaravelAdminExt\Select2\Traits\Select2Trait;

class Select extends BaseSelect
{
    protected $withId = 1;
    protected $ajax_appends = [];
    protected $view = 'laravel-admin-select2::select';

    use Select2Trait, FormTrait;
}
