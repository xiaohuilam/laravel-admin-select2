<?php
namespace LaravelAdminExt\Select2;

use Encore\Admin\Form\Field;

class Select2Field extends Field
{

    public $view = 'laravel-admin-select2::select2';

    protected function isSeaching()
    {
        if (request()->input('search') == $this->column) {
            return request()->input('keyword');
        }
        return false;
    }

    public function render()
    {
        $name = $this->formatName($this->column);

        $this->script = <<<SCRIPT

        $('#{$name}-select2').select2({
            theme: "bootstrap",
            minimumInputLength: 1,
            query: function (query) {
                $.ajax({
                    type: 'GET',
                    data: {
                        search: '{$name}',
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

    public function match($callback)
    {
        if (false === ($keyword = $this->isSeaching())) {
            return;
        }

        $query = $callback($keyword);
        $result = $query->paginate();

        echo json_encode(['success' => true, 'data' => [ 'list' => $result, ], ]);
        exit;
    }
}

