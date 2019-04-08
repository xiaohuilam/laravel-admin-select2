<?php
namespace LaravelAdminExt\Select2\Form\Field;

use Encore\Admin\Form\Field;
use Illuminate\Database\Eloquent\Relations\Relation;
use Encore\Admin\Form;

class MorphSelect extends Field
{
    protected $display = false;

    protected $type = [];

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
     * @param array $type
     */
    public function type($type = [])
    {
        $this->type = $type;
        $type = $this->type;
        $model = $this->form->model();

        /**
         * @var \Illuminate\Database\Eloquent\Relations\MorphTo $relation
         */
        if (!method_exists($model, $this->column) || !($relation = $model->{$this->column}()) || !$relation instanceof Relation) {
            abort(412, 'Sorry, there\'s no relation named ' . $this->column);
        }

        $this->form->select($relation->getMorphType())->options($type);
        return $this;
    }

    public function match($closure)
    {
        $this->match = $closure;
        $this->__show();
        return $this;
    }

    public function text($closure)
    {
        $this->text = $closure;
        $this->__show();
        return $this;
    }

    protected function __show()
    {
        if (!$this->match || !$this->text) {
            return;
        }
        $type = $this->type;
        $model = $this->form->model();

        /**
         * @var \Illuminate\Database\Eloquent\Relations\MorphTo $relation
         */
        if (!method_exists($model, $this->column) || !($relation = $model->{$this->column}()) || !$relation instanceof Relation) {
            abort(412, 'Sorry, there\'s no relation named ' . $this->column);
        }
        $func =<<<JAVASCRIPT
            $('.{$relation->getMorphType()}').val()
JAVASCRIPT;

        $this->form->select($relation->getForeignKeyName())
        ->setAppendAjaxParam('morph_type', $func)
        ->match(function ($keyword) use ($type) {
            $morph_type = request()->input('morph_type');
            if (!collect($type)->keys()->contains($morph_type)) {
                abort(412, 'Sorry, ' . $morph_type . ' is not allowed!');
            }

            $closure = $this->match;
            if (!is_callable($closure)) {
                return;
            }
            return $closure($keyword, $morph_type);
        })
        ->text(function ($value) use ($type) {
            $morph_type = request()->input('morph_type');
            if (!collect($type)->keys()->contains($morph_type)) {
                abort(412, 'Sorry, ' . $morph_type . ' is not allowed!');
            }

            $closure = $this->text;
            if (!is_callable($closure)) {
                return;
            }
            return $closure($value, $morph_type);
        });
    }
}
