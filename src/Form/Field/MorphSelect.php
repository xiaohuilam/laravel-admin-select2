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
        $this->type = collect($type);
    }

    public function match($closure)
    {
        $this->match = $closure;
    }

    public function text($closure)
    {
        $this->text = $closure;
    }

    /**
     * {@inheritDoc}
     */
    public function setForm(Form $form = null)
    {
        $type = $this->type;
        $model = $form->model();

        /**
         * @var \Illuminate\Database\Eloquent\Relations\MorphTo $relation
         */
        if (!method_exists($model, $this->column) || !($relation = $model->{$this->column}()) || !$relation instanceof Relation) {
            abort(412, 'Sorry, there\'s no relation named ' . $this->column);
        }

        $form->select($relation->getMorphType())->options($type);
        $form->select($relation->getForeignKeyName())->match(function ($keyword) use ($type) {
            $morph_type = request()->input('morph_type');
            if (!$type->contains($morph_type)) {
                abort(412, 'Sorry, ' . $morph_type . ' is not allowed!');
            }

            $closure = $this->match;
            if (!is_callable($closure)) {
                return;
            }
            $closure($keyword, $type);
        })->text(function ($value) {
            $closure = $this->text;
            if (!is_callable($closure)) {
                return;
            }
            $closure($value);            
        });

        parent::setForm($form);
    }
}
