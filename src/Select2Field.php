<?php
namespace LaravelAdminExt\Select2;

use Encore\Admin\Form\Field;

class Select2Field extends Field
{

    public $view = 'laravel-admin-select2::select2';

    /**
     * 是否为搜索请求，若是，返回搜索的关键词
     *
     * @return boolean|string
     */
    protected function isSeaching()
    {
        if (request()->input('search') == $this->column) {
            return request()->input('keyword');
        }
        return false;
    }

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
            }
        });
SCRIPT;
        return parent::render();
    }

    /**
     * 注册搜索逻辑
     *
     * @param Closure $callback
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function match($callback)
    {
        if (false === ($keyword = $this->isSeaching())) {
            return;
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
}

