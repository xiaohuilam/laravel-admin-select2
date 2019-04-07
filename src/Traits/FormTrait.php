<?php
namespace LaravelAdminExt\Select2\Traits;

trait FormTrait
{

    /**
     * 注册搜索逻辑
     *
     * @param Closure $callback
     * @return \Illuminate\Http\JsonResponse|self
     */
    public function match($callback)
    {
        if (false === $this->isSeaching()) {
            $this->ajax(request()->url() . '?&' . http_build_query(collect(request()->all())->merge(['search' => $this->column()])->toArray()));
            return $this;
        }

        $keyword = request()->input('keyword');
        /**
         * @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
         */
        $query = $callback($keyword);
        if (!$keyword) {
            $query->when(!strlen($keyword), function ($query) {
                $value = request()->input('value');

                /**
                 * @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
                 */
                $query = $query->where($this->form->model()->getKeyName(), '>', $value - 5);
            });
        }
        $result = $query->paginate();

        abort(response()->json($result));
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
        if (static::class == \LaravelAdminExt\Select2\Form\Field\MultipleSelect::class) {
            $value = explode(',', $value);
        }

        $result = $callback($value);

        abort(response()->json($result));
    }

    /**
     * Load options from ajax results.
     *
     * @param string $url
     * @param $idField
     * @param $textField
     *
     * @return $this
     */
    public function ajax($url, $idField = 'id', $textField = 'text')
    {
        $configs = array_merge([
            'allowClear'         => true,
            'placeholder'        => $this->label,
            'minimumInputLength' => 0,
        ], $this->config);
        $column = $this->column();

        $configs = json_encode($configs);
        $configs = substr($configs, 1, strlen($configs) - 2);

        $this->script = <<<EOT

$("{$this->getElementClassSelector()}").select2({
  ajax: {
    url: location.href,
    dataType: 'json',
    delay: 250,
    data: function (params) {
      var query = {
        keyword: params.term,
        page: params.page,
        search: '{$column}',
      };
      if (!query.keyword && {$this->withId}) {
        query.value = $("{$this->getElementClassSelector()}").attr('data-value');
      }
      return query;
    },
    processResults: function (data, params) {
      params.page = params.page || 1;
      return {
        results: $.map(data.data, function (d) {
          d.id = d.$idField;
          d.text = d.$textField;
          return d;
        }),
        pagination: {
          more: data.next_page_url
        }
      };
    },
    cache: true
  },
  $configs,
  escapeMarkup: function (markup) {
      return markup;
  },

  initSelection: function (element, callback) {
    var value = $("{$this->getElementClassSelector()}").attr('data-value');
    if (!value.trim().length) {
        return callback([]);
    };
    $.ajax({
      url: location.href,
      type: 'GET',
      data: {
        value: value,
        retrive: '{$column}',
      },
      dataType: 'json',
      success: function (json) {
        var id, text, init = [], option;
        for (id in json) {
            text = json[id] || '';
            init.push({
                id: id,
                text: text,
            });
            option = $('<option/>');
            option.val(id);
            option.attr('selected', 'selected');
            option.text(text);
            $("{$this->getElementClassSelector()}").append(option);
        }
        callback(init);
      },
    });
  }
});

EOT;
        return $this;
    }
}