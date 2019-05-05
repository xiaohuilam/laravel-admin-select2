<?php

namespace LaravelAdminExt\Select2\Test;

use Encore\Admin\Auth\Database\Administrator;

trait Menu
{
    protected function __init()
    {
        parent::setUp();
        $this->be(Administrator::first(), 'admin');
    }
}
