<?php

namespace LaravelAdminExt\Select2;

use Encore\Admin\Admin;
use Encore\Admin\Form;
use Illuminate\Support\ServiceProvider;
use LaravelAdminExt\Select2\Form\Field\Select;
use LaravelAdminExt\Select2\Form\Field\MorphSelect;
use LaravelAdminExt\Select2\Form\Field\MultipleSelect;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

        Admin::booting(function () {
            Form::registerBuiltinFields();
            Form::forget(['select', 'multipleSelect']);
            Form::extend('select', Select::class);
            Form::extend('multipleSelect', MultipleSelect::class);
            Form::extend('morphSelect', MorphSelect::class);
        });
        $this-> __compactLaravel55();
    }

    protected function __compactLaravel55()
    {
        if (!method_exists(BelongsTo::class, 'getForeignKeyName') && BelongsTo::hasMacro('getForeignKeyName')) {
            BelongsTo::macro('getForeignKeyName', function () {
                return $this->foreignKey;
            });
        }
        if (!method_exists(BelongsTo::class, 'getForeignKeyName') && BelongsTo::hasMacro('getForeignKeyName')) {
            BelongsTo::macro('getForeignKeyName', function () {
                return $this->foreignKey;
            });
        }
        if (!method_exists(HasOne::class, 'getForeignKeyName') && HasOne::hasMacro('getForeignKeyName')) {
            HasOne::macro('getForeignKeyName', function () {
                return $this->foreignKey;
            });
        }
        if (!method_exists(HasMany::class, 'getForeignKeyName') && HasMany::hasMacro('getForeignKeyName')) {
            HasMany::macro('getForeignKeyName', function () {
                return $this->foreignKey;
            });
        }
    }
}
