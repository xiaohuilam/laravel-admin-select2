# Laravel-Admin select2 插件

If you are non-Chinese user, there is [Document in English](README.md).

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

- [异步单选 (`select`) 示例代码](tests/Controllers/AnswerController.php#L35-L59)
- [异步多选 (`multipleSelect`) 示例代码](tests/Controllers/QuestionController.php#L35-L59)
- [异步多态关联选 (`morphSelect`) 择示例代码](tests/Controllers/CommentController.php#L34-L51)

## 赞助

**微信**

![donate.png](https://wantu-kw0-asset007-hz.oss-cn-hangzhou.aliyuncs.com/2GDNl84F6HW4PRGslxg.png?x-oss-process=image/resize,l_300)

## LICENSE

基于 [MIT](LICENSE) 协议开源.
