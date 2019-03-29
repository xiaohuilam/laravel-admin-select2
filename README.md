# Laravel-Admin select2 插件

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
             * @var \Illuminate\Database\Eloquent\Query $query 查询对象，切记如果数据模型没有text或id属性，记得as成text和id!
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

![screenshot.png](https://wantu-kw0-asset007-hz.oss-cn-hangzhou.aliyuncs.com/oxCsSnT5Yjc12ap5YTj.png)

## LICENSE

The 996 Prohibited License ([The 996ICU License](./LICENSE))
