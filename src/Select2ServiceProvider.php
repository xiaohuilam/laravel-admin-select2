<?php
namespace LaravelAdminExt\Select2;

use Encore\Admin\Admin;
use Illuminate\Support\ServiceProvider;
use LaravelAdminExt\Select2\Form\Field\Select;
use LaravelAdminExt\Select2\Form\Field\MultipleSelect;
use Encore\Admin\Form;

class Select2ServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(Select2 $extension)
    {
        if (!Select2::boot()) {
            return;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'laravel-admin-select2');
        }

        Admin::booting(function (){
            Form::registerBuiltinFields();
            Form::forget(['select', 'multipleSelect',]);
            Form::extend('select', Select::class);
            Form::extend('multipleSelect', MultipleSelect::class);
        });
    }
}
