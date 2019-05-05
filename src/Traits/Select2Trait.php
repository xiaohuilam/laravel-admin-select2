<?php

namespace LaravelAdminExt\Select2\Traits;

/**
 * @property array $ajax_appends
 */
trait Select2Trait
{
    /**
     * Is the request for searching?
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
     * Is the request for retriving?
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

    /**
     * Set extra ajax parameters.
     *
     * @param string $key
     * @param string $statement
     *
     * @return \LaravelAdminExt\Select2\Form\Field\Select|\LaravelAdminExt\Select2\Form\Field\MultipleSelect
     */
    public function setAppendAjaxParam($key, $statement)
    {
        $this->ajax_appends[$key] = trim($statement);

        return $this;
    }

    /**
     * Returns extra ajax parameters.
     *
     * @return array
     */
    public function getAppendAjaxParam()
    {
        return $this->ajax_appends;
    }
}
