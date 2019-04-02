# Laravel-Admin select2 插件

[![LICENSE](https://img.shields.io/badge/license-Anti%20996-blue.svg)](https://github.com/996icu/996.ICU/blob/master/LICENSE)

一款异步的 select2 针对 [laravel-admin](http://github.com/z-song/laravel-admin/) 插件，适用于不定条数的模型中选择框场景，如单选、多选（开发中，见[multiple-select2](https://github.com/xiaohuilam/laravel-admin-select2/tree/multiple-select2)分支）。

在表单中尝试检索时，才会 ajax 去模型中查询选项，设计极度精简。

## 安装
```bash
composer require xiaohuilam/laravel-admin-select2
```

## 使用

**代码**
```php
<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Form;
use App\Models\User;
use App\Models\UserResource;
use Illuminate\Support\Facades\DB;

class YourController extends Controller
{
    // ...
    protected function form()
    {
        $form = new Form(new UserResource);

        $form->select2('user_id', 'User id')->match(function ($keyword) {
            /**
             * @var \Illuminate\Database\Eloquent\Builder $query 查询对象，**切记如果数据模型没有text或id属性，记得as成text和id!**
             */
            $query = User::where('name', 'LIKE', '%' . $keyword . '%')->select([DB::raw('name AS text'), 'id',]);
            return $query;
        })->text(function ($id) {
            /**
             * @var string $text 一个字符串，用于将value显示出来
             */
            $text = data_get(User::find($id), 'name');
            return $text;
        });
        $form->text('title', 'Title');
        $form->textarea('content', 'Content');

        return $form;
    }
}
```

**截图**

![screenshot.png](https://wantu-kw0-asset007-hz.oss-cn-hangzhou.aliyuncs.com/4Sm9PDd6kScD9yS0wca.png)

## LICENSE

[Ant 996](https://github.com/996icu/996.ICU/blob/master/LICENSE)

