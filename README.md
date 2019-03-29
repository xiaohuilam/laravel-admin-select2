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
            // 需要返回一个 \Illuminate\Database\Eloquent\Query 对象
            return User::where('name', 'LIKE', '%' . $keyword . '%')->select([DB::raw('name AS text'), 'id',]);
        })->text(function ($id) {
            // 需要返回一个字符串，用于将value显示出来
            return data_get(User::find($id), 'name');
        });
        $form->text('title', 'Title');
        $form->textarea('content', 'Content');

        return $form;
    }
}
```

## LICENSE

The 996 Prohibited License(The 996ICU License)
Copyright © 2019 <Xiaohui Lam>

996ICU License 是一个关于 {MIT} 的扩展协议.
此协议扩展了 {MIT}, {MIT} 将在本协议文本末尾声明.

要求得到授权的个人履行以下义务:

1. 将此授权文件包含在其任何副本以及软件的重要部分中.

要求得到授权的组织履行以下义务:

1. 将此授权文件包含在其任何副本以及软件的重要部分中.
2. 不以任何形式或手段强迫其雇佣员工或临时劳动者进行超过法定最长劳动时间的劳动, 包括但不限于: 命令, 威胁, 暗示等.
3. 不以任何形式报复不参与超过法定最长劳动时间的劳动的雇佣员工或临时劳动者, 包括但不限于: 辱骂等精神攻击, 殴打等人身伤害以及非法开除等.
4. 此组织不在协议规定的黑名单中.

如果获得授权的个人或组织未能履行以上义务任意一条, 则授权将被收回.

此协议未定义的行为, 按 {MIT} 协议处理. {MIT} 与本协议冲突的部分, 按本协议处理.
