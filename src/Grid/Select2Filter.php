<?php

namespace LaravelAdminExt\Select2\Grid;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid\Displayers\AbstractDisplayer;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Arr;

class Select2Filter extends AbstractDisplayer
{
    /**
     * Display method.
     *
     * @return mixed
     */
    public function display()
    {
        $arguments = func_get_args();
        $column = $this->column->getName();

        if (isset($this->column->has_filter_select)) {
            return $this->row->{$column};
        }
        $options = Arr::first($arguments);

        if (request()->get('_search_' . $column)) {
            $query = call_user_func($options, request()->input('keyword'));
            ob_clean();
            echo response()->json($query->paginate())->getContent();
            exit;
            //throw new HttpResponseException(response()->json($query->paginate()));
        }

        $this->column->addHeader(view('laravel-admin-select2::filter_select', ['column' => $column, 'uri' => $this->getFormAction($column),]));
        $this->column->has_filter_select = true;

        Admin::js(asset('vendor/laravel-admin-ext/laravel-admin-select2/filter-select.js'), true, true);
        Admin::script('window.select2_filter("' . $this->column->getName() . '")', true);
        return $this->row->{$column};
    }

    /**
     * Get form action url.
     *
     * @return string
     */
    protected function getFormAction($column)
    {
        $request = request();

        $query = $request->query();
        Arr::forget($query, [$column, '_pjax']);

        $question = $request->getBaseUrl().$request->getPathInfo() == '/' ? '/?' : '?';

        return count($request->query()) > 0
            ? $request->url().$question.http_build_query($query)
            : $request->fullUrl();
    }
}
