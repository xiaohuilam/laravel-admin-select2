# Laravel-Admin select2 插件

一款异步的 select2 针对 [laravel-admin](http://github.com/z-song/laravel-admin/) 插件，适用于不定条数的模型中选择框场景，包括单选、多选。

在表单中尝试检索时，才会 ajax 去模型中查询选项，设计极度精简。

*. 扩展自 laravel-admin 的 select 和 multipleSelect 的Field类型，兼容原有方法。

[![travis.svg](https://img.shields.io/travis/xiaohuilam/laravel-admin-select2/master.svg?style=flat-square)](https://travis-ci.org/xiaohuilam/laravel-admin-select2)
[![styleci.svg](https://github.styleci.io/repos/178165826/shield?branch=master)](https://github.styleci.io/repos/178165826)
[![version.svg](https://img.shields.io/packagist/vpre/xiaohuilam/laravel-admin-select2.svg?style=flat-square)](https://packagist.org/packages/xiaohuilam/laravel-admin-select2)
[![issues-open.svg](https://img.shields.io/github/issues/xiaohuilam/laravel-admin-select2.svg?style=flat-square)](https://github.com/xiaohuilam/laravel-admin-select2/issues)
[![last-commit.svg](https://img.shields.io/github/last-commit/xiaohuilam/laravel-admin-select2.svg?style=flat-square)](https://github.com/xiaohuilam/laravel-admin-select2/commits/)
[![contributors.svg](https://img.shields.io/github/contributors/xiaohuilam/laravel-admin-select2.svg?style=flat-square)](https://github.com/xiaohuilam/laravel-admin-select2/graphs/contributors)
[![install-count.svg](https://img.shields.io/packagist/dt/xiaohuilam/laravel-admin-select2.svg?style=flat-square)](https://packagist.org/packages/xiaohuilam/laravel-admin-select2)
[![license.svg](https://img.shields.io/github/license/xiaohuilam/laravel-admin-select2.svg?style=flat-square)](LICENSE)

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
    protected function form()
    {
        $form = new Form(new UserResource);

        $form->select('user_id', 'User id')->match(function ($keyword) {
            /**
             * @var \Illuminate\Database\Eloquent\Builder $query 查询对象，**切记如果数据模型没有text或id属性，记得as成text和id!**
             */
            $query = User::where('name', 'LIKE', '%' . $keyword . '%')->select([DB::raw('name AS text'), 'id',]);
            return $query;
        })->text(function ($id) {
            return User::where(app(User::class)->getKeyName(), $id)->pluck('name', 'id');
        });

        $form->multipleSelect('tags', 'Tags')->match(
            function ($keyword) {
                return Tag::where('name', 'LIKE', '%' . $keyword . '%')->select([DB::raw('name AS text'), 'id',]);
            }
        )
        ->text(
            function ($id_list) {
                return Tag::whereIn(app(Tag::class)->getKeyName(), $id_list)->pluck('name', 'id');
            }
        );


        $form->text('title', 'Title');
        $form->textarea('content', 'Content');

        return $form;
    }
}
```

**截图**

![screenshot.png](https://wantu-kw0-asset007-hz.oss-cn-hangzhou.aliyuncs.com/G5l12nD7D73p56dvXBm.png?x-oss-process=image/resize,l_500)


## 赞助

**微信**

![donate.png](https://wantu-kw0-asset007-hz.oss-cn-hangzhou.aliyuncs.com/2GDNl84F6HW4PRGslxg.png?x-oss-process=image/resize,l_300)

## LICENSE

Open source under [MIT](LICENSE) LICENSE.