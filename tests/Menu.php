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

    public function testAddMenu()
    {
        $item = ['parent_id' => '0', 'title' => 'Test', 'uri' => 'test/*'];
        $this->visit('admin/auth/menu')
            ->seePageIs('admin/auth/menu')
            ->submitForm('Submit', $item)
            ->seePageIs('admin/auth/menu');

        $this->expectException(\Laravel\BrowserKitTesting\HttpException::class);

        $this->visit('admin')->see('Test')->click('Test');
    }
}
