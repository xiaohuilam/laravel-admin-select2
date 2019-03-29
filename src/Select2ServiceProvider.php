<?php
namespace LaravelAdminExt\Select2;

use Encore\Admin\Admin;
use Illuminate\Support\ServiceProvider;
use Encore\Admin\Form;

class Select2ServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(Select2 $extension)
    {
        if (! Select2::boot()) {
            return ;
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/laravel-admin-ext/select2')],
                'laravel-admin-select2'
            );
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'laravel-admin-select2');
        }

        Admin::booting(function (){
            Admin::css('vendor/laravel-admin-ext/select2/css/select2.css');
            Admin::css('vendor/laravel-admin-ext/select2/css/select2-bootstrap.css');
            Admin::js('vendor/laravel-admin-ext/select2/js/select2.js');
            Form::extend('select2', Select2Field::class);
        });
    }
}
