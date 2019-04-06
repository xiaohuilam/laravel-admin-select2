<?php
namespace LaravelAdminExt\Select2;

use Encore\Admin\Admin;
use Illuminate\Support\ServiceProvider;

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
        });
    }
}
