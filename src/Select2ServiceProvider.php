<?php

namespace LaravelAdminExt\Select2;

use Encore\Admin\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid\Column;
use Illuminate\Support\ServiceProvider;
use LaravelAdminExt\Select2\Form\Field\Select;
use LaravelAdminExt\Select2\Form\Field\MorphSelect;
use LaravelAdminExt\Select2\Form\Field\MultipleSelect;
use LaravelAdminExt\Select2\Grid\Select2Filter;

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

            Column::extend('filterSelect2', Select2Filter::class);
        });
    }

    public function register()
    {
        $this->publishes([
            __DIR__ . '/../resources/js/filter-select.js' => public_path('vendor/laravel-admin-ext/laravel-admin-select2/filter-select.js'),
        ], 'laravel-admin-select2');
    }
}
