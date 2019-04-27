# Laravel-Admin select2 extension

中文用户请阅读 [中文文档](README_cn.md).

A asynchronous extension to implements select2 to [laravel-admin](http://github.com/z-song/laravel-admin/), including single select/multiple select/morph select.

It will send ajax query if only you trigger list option in the form.

*. extends from laravel-admin's original select, multipleSelect Fields, so it's compatible with laravel-admin select field.

[![travis.svg](https://img.shields.io/travis/xiaohuilam/laravel-admin-select2/master.svg?style=flat-square)](https://travis-ci.org/xiaohuilam/laravel-admin-select2)
[![styleci.svg](https://github.styleci.io/repos/178165826/shield?branch=master)](https://github.styleci.io/repos/178165826)
[![code-quality.svg](https://img.shields.io/scrutinizer/g/xiaohuilam/laravel-admin-select2.svg?style=flat-square)](https://scrutinizer-ci.com/g/xiaohuilam/laravel-admin-select2/)
[![version.svg](https://img.shields.io/packagist/vpre/xiaohuilam/laravel-admin-select2.svg?style=flat-square)](https://packagist.org/packages/xiaohuilam/laravel-admin-select2)
[![issues-open.svg](https://img.shields.io/github/issues/xiaohuilam/laravel-admin-select2.svg?style=flat-square)](https://github.com/xiaohuilam/laravel-admin-select2/issues)
[![last-commit.svg](https://img.shields.io/github/last-commit/xiaohuilam/laravel-admin-select2.svg?style=flat-square)](https://github.com/xiaohuilam/laravel-admin-select2/commits/)
[![contributors.svg](https://img.shields.io/github/contributors/xiaohuilam/laravel-admin-select2.svg?style=flat-square)](https://github.com/xiaohuilam/laravel-admin-select2/graphs/contributors)
[![install-count.svg](https://img.shields.io/packagist/dt/xiaohuilam/laravel-admin-select2.svg?style=flat-square)](https://packagist.org/packages/xiaohuilam/laravel-admin-select2)
[![license.svg](https://img.shields.io/github/license/xiaohuilam/laravel-admin-select2.svg?style=flat-square)](LICENSE)

## Installation
```bash
composer require xiaohuilam/laravel-admin-select2
```

## Usage

- [asynchronous single select (`select`) demo](tests/Controllers/AnswerController.php#L35-L59)
- [asynchronous multiple select (`multipleSelect`) demo](tests/Controllers/QuestionController.php#L35-L59)
- [asynchronous morph select (`morphSelect`) demo](tests/Controllers/CommentController.php#L34-L51)

## Donation
[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.me/laravel)

## LICENSE

Open source under [MIT](LICENSE) LICENSE.