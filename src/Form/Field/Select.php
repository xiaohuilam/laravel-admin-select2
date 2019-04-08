<?php
namespace LaravelAdminExt\Select2\Form\Field;

use Encore\Admin\Form\Field\Select as BaseSelect;
use LaravelAdminExt\Select2\Traits\Select2Trait;
use LaravelAdminExt\Select2\Traits\FormTrait;

class Select extends BaseSelect
{
    protected $withId = 1;
    protected $ajax_appends = [];

    use Select2Trait, FormTrait;

    /**
     * Get view of this field.
     *
     * @return string
     */
    public function getView()
    {
        return 'laravel-admin-select2::select';
    }
}
