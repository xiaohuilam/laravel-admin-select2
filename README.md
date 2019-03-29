# Laravel-Admin select2 插件

## 安装
composer require xiaohuilam/laravel-admin-select2

## 使用
```php
<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Models\User;
use App\Models\UserResource;
use Illuminate\Support\Facades\DB;

class YourController extends Controller
{
    // ... 省略其他代码

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new UserResource);

        $form->select2('user_id', 'User id')->match(function ($keyword) {
            return User::where('name', 'LIKE', '%' . $keyword . '%')->select([DB::raw('name AS text'), 'id',]);
        });
        $form->text('title', 'Title');
        $form->textarea('content', 'Content');

        return $form;
    }
}
```

## LICENSE
MIT
