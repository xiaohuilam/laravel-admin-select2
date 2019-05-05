<?php

namespace LaravelAdminExt\Select2;

use Encore\Admin\Admin;
use Encore\Admin\Form;
use Illuminate\Support\ServiceProvider;
use LaravelAdminExt\Select2\Form\Field\Select;
use LaravelAdminExt\Select2\Form\Field\MorphSelect;
use LaravelAdminExt\Select2\Form\Field\MultipleSelect;

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

        Admin::booted(function () {
            Form::forget(['select', 'multipleSelect']);
            Form::extend('select', Select::class);
            Form::extend('multipleSelect', MultipleSelect::class);
            Form::extend('morphSelect', MorphSelect::class);
        });
    }
}
