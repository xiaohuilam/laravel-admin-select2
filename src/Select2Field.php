<?php
namespace LaravelAdminExt\Select2;

use Encore\Admin\Form\Field;
use LaravelAdminExt\Select2\Traits\Select2Trait;

class Select2Field extends Field
{
    use Select2Trait;

    public $view = 'laravel-admin-select2::select2';

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $column = $this->column;
        $name = $this->formatName($this->column);

        $this->script = <<<SCRIPT

        $('#{$name}-select2').select2({
            theme: "bootstrap",
            minimumInputLength: 1,
            query: function (query) {
                $.ajax({
                    url: location.href,
                    type: 'GET',
                    data: {
                        search: '{$column}',
                        keyword: query.term,
                    },
                    dataType: 'json',
                    success: function (json) {
                        var data = {results: []};

                        data.results = json.data.list.data;
                        query.callback(data);
                    },
                });
            },
            initSelection: function (element, callback) {
                var value = $('#{$name}-select2').val();
                if (!value.trim().length) return;
                $.ajax({
                    url: location.href,
                    type: 'GET',
                    data: {
                        retrive: '{$column}',
                        value: value,
                    },
                    dataType: 'json',
                    success: function (json) {
                        callback({id: value, text: json.data.text });
                    },
                });
            }
        });
SCRIPT;
        return parent::render();
    }

    /**
     * 注册搜索逻辑
     *
     * @param Closure $callback
     * @return \Illuminate\Http\JsonResponse|self
     */
    public function match($callback)
    {
        if (false === ($keyword = $this->isSeaching())) {
            return $this;
        }

        /**
         * @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
         */
        $query = $callback($keyword);
        $result = $query->paginate();

        // 因为laravel-admin局限，目前没有更好的方案
        echo json_encode(['success' => true, 'data' => [ 'list' => $result, ], ]);
        exit;
    }

    /**
     * 显示值逻辑
     *
     * @param Closure $callback
     * @return string|self
     */
    public function text($callback)
    {
        if (false === ($value = $this->isTextRetriving())) {
            return $this;
        }

        $text = $callback($value);

        // 因为laravel-admin局限，目前没有更好的方案
        echo json_encode(['success' => true, 'data' => ['text' => $text, ], ]);
        exit;
    }
}
