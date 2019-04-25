<?php

namespace LaravelAdminExt\Select2\Grid\Displayers;

use Encore\Admin\Grid\Displayers\Editable as BaseEditable;
use Encore\Admin\Facades\Admin;

class Editable extends BaseEditable
{
    /**
     * {@inheritdoc}
     */
    public function select($options = [])
    {
        $parameters = func_get_args();
        $text = data_get($parameters, 1);

        if ($text && is_callable($text)) {
            $this->options['asynchronous'] = true;
        } else {
            $this->options['asynchronous'] = false;
            return parent::select($options);
        }
    }

    protected function buildEditableOptions(array $arguments = [])
    {
        if (!data_get($this->options, 'asynchronous', false)) {
            $this->type = array_get($arguments, 0, 'text');
            call_user_func_array([$this, $this->type], array_slice($arguments, 1));
            return;
        }
    }

    public function display()
    {
        if (!data_get($this->options, 'asynchronous', false)) {
            return parent::display();
        }

        $options = <<<JSON
{
    type: 'select2',
    url: '/post',
    pk: 1,
    onblur: 'submit',
    emptytext: 'None',
    select2: {
        placeholder: 'Select a Requester',
        allowClear: true,
        width: '230px',
        minimumInputLength: 3,
        id: function (e) {
            return e.EmployeeId;
        },
        ajax: {
            url: '/EmployeeSearch',
            dataType: 'json',
            data: function (term, page) {
                return {
                    query: term
                };
            },
            results: function (data, page) {
                return {
                    results: data
                };
            }
        },
        formatResult: function (employee) {
            return employee.EmployeeName;
        },
        formatSelection: function (employee) {
            return employee.EmployeeName;
        },
        initSelection: function (element, callback) {
            return $.get('/EmployeeLookupById',
                {
                    query: element.val()
                }, function (data) {
                    callback(data);
                }, 'json'); //added dataType
        }
    }
}
JSON;
        $this->options['name'] = $column = $this->column->getName();

        $class = 'grid-editable-' . str_replace(['.', '#', '[', ']'], '-', $column);

        dd("$('.$class').editable($options);");
        Admin::script("$('.$class').editable($options);");

        $this->value = htmlentities($this->value);

        $attributes = [
            'href'       => '#',
            'class'      => "$class",
            'data-type'  => $this->type,
            'data-pk'    => "{$this->getKey()}",
            '_data-url'   => "{$this->grid->resource()}/{$this->getKey()}",
            '_data-value' => "{$this->value}",
        ];

        if (!empty($this->attributes)) {
            $attributes = array_merge($attributes, $this->attributes);
        }

        $attributes = collect($attributes)->map(function ($attribute, $name) {
            return "$name='$attribute'";
        })->implode(' ');

        $html = $this->type === 'select' ? '' : $this->value;

        return "<a $attributes>{$html}</a>";
    }
}
