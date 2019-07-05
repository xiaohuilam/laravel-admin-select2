<h1 align="center">𝑳𝒂𝒓𝒂𝒗𝒆𝒍-𝑨𝒅𝒎𝒊𝒏 𝒔𝒆𝒍𝒆𝒄𝒕2 𝒂𝒔𝒚𝒏𝒄𝒉𝒓𝒐𝒏𝒐𝒖𝒔 𝒆𝒙𝒕𝒆𝒏𝒔𝒊𝒐𝒏</h1>

<div align="center">

[![travis.svg](https://img.shields.io/travis/xiaohuilam/laravel-admin-select2/master.svg)](https://travis-ci.org/xiaohuilam/laravel-admin-select2)
[![version.svg](https://img.shields.io/packagist/vpre/xiaohuilam/laravel-admin-select2.svg)](https://packagist.org/packages/xiaohuilam/laravel-admin-select2)
[![issues-open.svg](https://img.shields.io/github/issues/xiaohuilam/laravel-admin-select2.svg)](https://github.com/xiaohuilam/laravel-admin-select2/issues)
[![install-count.svg](https://img.shields.io/packagist/dt/xiaohuilam/laravel-admin-select2.svg)](https://packagist.org/packages/xiaohuilam/laravel-admin-select2)
[![license.svg](https://img.shields.io/github/license/xiaohuilam/laravel-admin-select2.svg)](LICENSE)

</div>

## About

中文用户请阅读 [中文文档](README_cn.md).

A asynchronous extension to implements select2 to [laravel-admin](http://github.com/z-song/laravel-admin/), including single select/multiple select/morph select.

It will send ajax query if only you trigger list option in the form.

*. extends from laravel-admin's original select, multipleSelect Fields, so it's compatible with laravel-admin select field.

## Installation
```bash
composer require xiaohuilam/laravel-admin-select2
```

## Usage

- [asynchronous single select (`select`) demo](tests/Controllers/AnswerController.php#L35-L59)
- [asynchronous multiple select (`multipleSelect`) demo](tests/Controllers/QuestionController.php#L35-L59)
- [asynchronous morph select (`morphSelect`) demo](tests/Controllers/CommentController.php#L34-L51)

## Structure
```
src
├── Form
│   └── Field
│       ├── Select.php           # `LaravelAdminExt\Select2\Form\Field\Select` single select class
│       ├── MultipleSelect.php   # `LaravelAdminExt\Select2\Form\Field\MultipleSelect` multiple select class
│       └── MorphSelect.php      # `LaravelAdminExt\Select2\Form\Field\MorphSelect` morph select class
├── Interfaces
│   └── MorphSelectInterface.php # `LaravelAdminExt\Select2\Interfaces\MorphSelectInterface` morph select interface. must implement in every morphed models.
├── Select2.php                  # laravel-admin extension identify file
├── Select2ServiceProvider.php   # laravel service provider
└── Traits                       # some multiplexing methods
    ├── FormTrait.php
    └── Select2Trait.php
```

## Donation
[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.me/laravel)

## LICENSE

Open source under [MIT](LICENSE) LICENSE.