<?php

namespace LaravelAdminExt\Select2\Form\Field;

use Illuminate\Support\Str;
use Encore\Admin\Form\Field;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\Relation;
use LaravelAdminExt\Select2\Interfaces\MorphSelectInterface;

/**
 * MorphSelect field
 *
 * @method string column()
 */
class MorphSelect extends Field
{
    protected $display = false;

    /**
     * @var array
     */
    protected $class_map = [];

    /**
     * @var \Closure|null
     */
    protected $match = null;

    /**
     * @var \Closure|null
     */
    protected $text = null;

    /**
     * Column name.
     *
     * @var string
     */
    protected $column = '';

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
        if (empty($this->class_map)) {
            return $this;
        }

        foreach ($this->class_map as $class => $text) {
            /**
             * @var \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\LaravelAdminExt\Select2\Interfaces\MorphSelectInterface $morph_class
             */
            $morph_class = app($class);
            if (!$morph_class instanceof MorphSelectInterface) {
                abort(412, $class . ' must implements ' . MorphSelectInterface::class);
            }
        }

        if (!$this->match || !$this->text) {
            $this->match = function ($keyword, $class) {
                /**
                 * @var \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\LaravelAdminExt\Select2\Interfaces\MorphSelectInterface $morph_class
                 */
                $morph_class = app($class);

                /**
                 * @var \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\LaravelAdminExt\Select2\Interfaces\MorphSelectInterface $query
                 */
                $query = app($class);

                /**
                 * @var string $column
                 */
                $column = $query::getTextColumn();

                return $query->where($column, 'LIKE', DB::raw('"%' . $keyword . '%"'))
                    ->select([DB::raw($column . ' AS text'), DB::raw($morph_class->getKeyName() . ' AS id')]);
            };
            $this->text = function ($id, $class) {
                /**
                 * @var \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\LaravelAdminExt\Select2\Interfaces\MorphSelectInterface $morph_class
                 */
                $morph_class = app($class);

                /**
                 * @var \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\SoftDeletes $query
                 */
                $query = app($class);
                if (method_exists($morph_class, 'trashed')) {
                    $query = $query->withTrashed();
                }

                /**
                 * @var string $id_name
                 */
                $id_name = $morph_class->getKeyName();

                /**
                 * @var string $column
                 */
                $column = $morph_class->getTextColumn();

                return $query->where($id_name, $id)->pluck($column, $id_name);
            };
        }
        $type = $this->class_map;
        $model = $this->form->model();

        /**
         * @var \Illuminate\Database\Eloquent\Relations\MorphTo $relation
         */
        $relation = $model->{$this->column}();

        /**
         * @var string $type_column
         */
        $type_column = $relation->getMorphType();

        if (!method_exists($model, $this->column) || !$relation || !$relation instanceof Relation) {
            abort(412, 'Sorry, there\'s no relation named ' . $this->column);
        }
        $func = "$('.{$type_column}').val()";

        $this->form
            ->select($type_column, Str::studly($this->column()))
            ->options($type)
            ->setView('laravel-admin-select2::morph.type');

        $callback = function ($text) {
            /**
             * @var string $morph_type
             */
            $morph_type = request()->input('morph_type');
            if (method_exists($morph_type, 'transformText')) {
                /**
                 * @var \Illuminate\Database\Eloquent\Model|\LaravelAdminExt\Select2\Interfaces\MorphSelectInterface $morph_object
                 */
                $morph_object = app($morph_type);
                $text = $morph_object::transformText($text);
            }
            return $text;
        };

        /**
         * @var string $id_name
         */
        $id_name = method_exists($relation, 'getForeignKeyName') ? $relation->getForeignKeyName() : ($this->column() . '_id');

        /**
         * @var \LaravelAdminExt\Select2\Form\Field\Select $field
         */
        $field = $this->form->select($id_name);
        $field->setAppendAjaxParam('morph_type', $func)
            ->match(function ($keyword) use ($type) {
                /**
                 * @var string $morph_type
                 */
                $morph_type = request()->input('morph_type');
                if (!collect($type)->keys()->contains($morph_type)) {
                    abort(412, 'Sorry, ' . $morph_type . ' is not allowed!');
                }

                $closure = $this->match;
                if (!is_callable($closure)) {
                    return $this;
                }
                return $closure($keyword, $morph_type);
            }, $callback)
            ->text(function ($value) use ($type) {
                /**
                 * @var string $morph_type
                 */
                $morph_type = request()->input('morph_type');
                if (!collect($type)->keys()->contains($morph_type)) {
                    abort(412, 'Sorry, ' . $morph_type . ' is not allowed!');
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
