<?php

namespace LaravelAdminExt\Select2\Traits;

trait Select2Trait
{
    /**
     * 是否为搜索请求，若是，返回搜索的关键词.
     *
     * @return bool|string
     */
    protected function isSeaching()
    {
        /**
         * @var \LaravelAdminExt\Select2\Form\Field\Select|\LaravelAdminExt\Select2\Form\Field\MultipleSelect
         */
        $self = $this;
        if (request()->input('search') == $self->column) {
            return true;
        }

        return false;
    }

    /**
     * 是否为获取显示值请求，若是，返回显示值
     *
     * @return bool|string
     */
    protected function isTextRetriving()
    {
        /**
         * @var \LaravelAdminExt\Select2\Form\Field\Select|\LaravelAdminExt\Select2\Form\Field\MultipleSelect
         */
        $self = $this;
        if (request()->input('retrive') == $self->column) {
            return request()->input('value');
        }

        return false;
    }
}
