<?php
namespace LaravelAdminExt\Select2;

use Encore\Admin\Form\Field;
use LaravelAdminExt\Select2\Traits\Select2Trait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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
            minimumInputLength: 0,
            ajax: {
                url: location.href,
                dataType: 'json',
                quietMillis: 250,
                data: function (term, page) {
                    return {
                        search: '{$column}',
                        keyword: term,
                        id: $('#{$name}-select2').val(),
                        page: page,
                    };
                },
                results: function (data, page) {
                    return { results: data.data.list.data, more: data.data.list.next_page_url != null };
                },
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
        if (false === $this->isSeaching()) {
            return $this;
        }

        $keyword = request()->input('keyword');
        /**
         * @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
         */
        $query = $callback($keyword);
        if (!$keyword) {
            $query->when(!strlen($keyword), function ($query) {
                $id = request()->input('id');

                /**
                 * @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
                 */
                $query = $query->where($this->form->model()->getKeyName(), '>', $id - 5);
            });
        }
        $result = $query->paginate();

        abort(response()->json(['success' => true, 'data' => [ 'list' => $result, ], ]));
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

        abort(response()->json(['success' => true, 'data' => ['text' => $text, ], ]));
    }
}
