<?php
namespace LaravelAdminExt\Select2\Traits;

trait Select2Trait
{
    /**
     * 是否为搜索请求，若是，返回搜索的关键词
     *
     * @return boolean|string
     */
    protected function isSeaching()
    {
        /**
         * @var \LaravelAdminExt\Select2\Form\Field\Select|\LaravelAdminExt\Select2\Form\Field\MultipleSelect $self
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
     * @return boolean|string
     */
    protected function isTextRetriving()
    {
        /**
         * @var \LaravelAdminExt\Select2\Form\Field\Select|\LaravelAdminExt\Select2\Form\Field\MultipleSelect $self
         */
        $self = $this;
        if (request()->input('retrive') == $self->column) {
            return request()->input('value');
        }
        return false;
    }

    /**
     * 设置额外ajax参数
     *
     * @param string $key
     * @param string $statement
     * @return \LaravelAdminExt\Select2\Form\Field\Select|\LaravelAdminExt\Select2\Form\Field\MultipleSelect
     */
    public function setAppendAjaxParam($key, $statement)
    {
        $this->ajax_appends[$key] = trim($statement);
        return $this;
    }

    /**
     * 返回额外ajax参数
     *
     * @return array
     */
    public function getAppendAjaxParam()
    {
        return $this->ajax_appends;
    }
}
