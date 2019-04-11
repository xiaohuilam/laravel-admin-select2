<?php

namespace LaravelAdminExt\Select2\Form\Field;

use Encore\Admin\Form\Field;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use LaravelAdminExt\Select2\Interfaces\MorphSelectInterface;

class MorphSelect extends Field
{
    protected $display = false;

    /**
     * @var array
     */
    protected $class_map = [];

    /**
     * @var \Closure|\Callable
     */
    protected $match = null;

    /**
     * @var \Closure|\Callable
     */
    protected $text = null;

    /**
     * Field constructor.
     *
     * @param array $class_map
     */
    public function type($class_map = [])
    {
        $this->class_map = $class_map;
        return $this->__show();
    }

    protected function __show()
    {
        if (!$this->class_map) {
            return $this;
        }

        foreach ($this->class_map as $class => $text) {
            if (!app($class) instanceof MorphSelectInterface) {
                abort(412, $class . ' must implements ' . MorphSelectInterface::class);
            }
        }

        if (!$this->match || !$this->text) {
            $this->match = function ($keyword, $class) {
                /**
                 * @var \Illuminate\Database\Eloquent\Model|\LaravelAdminExt\Select2\Interfaces\MorphSelectInterface $query
                 */
                $query = $class;
                return $query::where($query::getTextColumn(), 'LIKE', DB::raw('"%' . $keyword . '%"'))
                    ->select([DB::raw($query::getTextColumn() . ' AS text'), DB::raw(app($class)->getKeyName() . ' AS id')]);
            };
            $this->text = function ($id, $class) {
                /**
                 * @var \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\SoftDeletes $query
                 */
                $query = $class;
                if (method_exists(app($class), 'trashed')) {
                    $query = $query::withTrashed();
                }

                return $query->where(app($class)->getKeyName(), $id)->pluck('content', app($class)->getKeyName());
            };
        }
        $type = $this->class_map;
        $model = $this->form->model();

        /**
         * @var \Illuminate\Database\Eloquent\Relations\MorphTo $relation
         */
        if (!method_exists($model, $this->column) || !($relation = $model->{$this->column}()) || !$relation instanceof Relation) {
            abort(412, 'Sorry, there\'s no relation named '.$this->column);
        }
        $func = "$('.{$relation->getMorphType()}').val()";

        $this->form
            ->select($relation->getMorphType(), studly_case($this->column()))
            ->options($type)
            ->setView('laravel-admin-select2::morph.type');

        $callback = function ($text) {
            $morph_type = request()->input('morph_type');
            if (method_exists($morph_type, 'transformText')) {
                $text = app($morph_type)::transformText($text);
            }
            return $text;
        };

        $this->form
            ->select(method_exists($relation, 'getForeignKeyName') ? $relation->getForeignKeyName() : ($this->column() . '_id'))
            ->setAppendAjaxParam('morph_type', $func)
            ->match(function ($keyword) use ($type) {
                $morph_type = request()->input('morph_type');
                if (!collect($type)->keys()->contains($morph_type)) {
                    abort(412, 'Sorry, '.$morph_type.' is not allowed!');
                }

                $closure = $this->match;
                if (!is_callable($closure)) {
                    return $this;
                }
                return $closure($keyword, $morph_type);
            }, $callback)
            ->text(function ($value) use ($type) {
                $morph_type = request()->input('morph_type');
                if (!collect($type)->keys()->contains($morph_type)) {
                    abort(412, 'Sorry, '.$morph_type.' is not allowed!');
                }

                $closure = $this->text;
                if (!is_callable($closure)) {
                    return $this;
                }
                return $closure($value, $morph_type);
            }, $callback)
            ->setView('laravel-admin-select2::morph.id');

        return $this;
    }
}
