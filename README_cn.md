<h1 align="center">Laravel-Admin select2 异步插件</h1>

<div align="center">

[![travis.svg](https://img.shields.io/travis/xiaohuilam/laravel-admin-select2/master.svg)](https://travis-ci.org/xiaohuilam/laravel-admin-select2)
[![version.svg](https://img.shields.io/packagist/vpre/xiaohuilam/laravel-admin-select2.svg)](https://packagist.org/packages/xiaohuilam/laravel-admin-select2)
[![issues-open.svg](https://img.shields.io/github/issues/xiaohuilam/laravel-admin-select2.svg)](https://github.com/xiaohuilam/laravel-admin-select2/issues)
[![install-count.svg](https://img.shields.io/packagist/dt/xiaohuilam/laravel-admin-select2.svg)](https://packagist.org/packages/xiaohuilam/laravel-admin-select2)
[![license.svg](https://img.shields.io/github/license/xiaohuilam/laravel-admin-select2.svg)](LICENSE)

</div>

## 关于

If you are non-Chinese user, there is [Document in English](README.md).

一款异步的 select2 针对 [laravel-admin](http://github.com/z-song/laravel-admin/) 插件，适用于不定条数的模型中选择框场景，包括单选、多选。

在表单中尝试检索时，才会 ajax 去模型中查询选项，设计极度精简。

*. 扩展自 laravel-admin 的 select 和 multipleSelect 的Field类型，兼容原有方法。

## 安装
```bash
composer require xiaohuilam/laravel-admin-select2
```

## 使用

- [异步单选 (`select`) 示例代码](tests/Controllers/AnswerController.php#L35-L59)
- [异步多选 (`multipleSelect`) 示例代码](tests/Controllers/QuestionController.php#L35-L59)
- [异步多态关联选 (`morphSelect`) 择示例代码](tests/Controllers/CommentController.php#L34-L51)

## 文件结构
```
src
├── Form
│   └── Field
│       ├── Select.php           # `LaravelAdminExt\Select2\Form\Field\Select` 单选类代码
│       ├── MultipleSelect.php   # `LaravelAdminExt\Select2\Form\Field\MultipleSelect` 多选类代码
│       └── MorphSelect.php      # `LaravelAdminExt\Select2\Form\Field\MorphSelect` 模态多选类代码
├── Interfaces
│   └── MorphSelectInterface.php # `LaravelAdminExt\Select2\Interfaces\MorphSelectInterface` 模态多选接口. 在被 morphSelect 的使用的模型中必须 implments.
├── Select2.php                  # laravel-admin 扩展标识文件
├── Select2ServiceProvider.php   # laravel 服务提供者文件
└── Traits                       # 一些在 select 和 multipleSelect 被复用的方法
    ├── FormTrait.php
    └── Select2Trait.php
```

## 赞助

**微信**

![donate.png](https://wantu-kw0-asset007-hz.oss-cn-hangzhou.aliyuncs.com/2GDNl84F6HW4PRGslxg.png?x-oss-process=image/resize,l_300)

## LICENSE

基于 [MIT](LICENSE) 协议开源.
