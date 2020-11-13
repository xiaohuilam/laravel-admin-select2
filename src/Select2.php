<?php

namespace LaravelAdminExt\Select2;

use Encore\Admin\Extension;

class Select2 extends Extension
{
    public $name = 'select2';
    public $views = __DIR__ . '/../resources/views';

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        if ('laravel-admin-select2::morph.type' === $this->view) {
            return str_replace('<!--type-->' . PHP_EOL . '</div>', '', parent::render());
        }

        return parent::render();
    }
}
