<?php

namespace LaravelAdminExt\Select2\Test\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Grid;
use LaravelAdminExt\Select2\Test\Models\Answer;
use LaravelAdminExt\Select2\Test\Models\Question;
use Illuminate\Support\Facades\DB;

/**
 * A demo for select, see it in the `form()` method
 */
class AnswerController extends Controller
{
    use HasResourceActions;

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Answer);

        $form->select('question_id', 'Question')->match(function ($keyword) {
            return Question::where('title', 'LIKE', '%' . $keyword . '%')

                // because select2 js plugin needs `text` and `id` column,
                // so if your model does not contains these two, remember to AS for them
                ->select([DB::raw('title AS text'), 'id',])
                ->latest();
        })->text(function ($id) {
            // return type is `{id1: text1, id2: text2...}
            return Question::whereIn('id', [$id])->pluck('title', 'id');
        });

        $form->textarea('content', 'Content');

        return $form;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Answer);

        $grid->column('user_id', __('User'))->sortable()->filterSelect2(function ($keyword) {
            return User::where('name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                ->select([DB::raw('email AS text'), 'id',]);
        });
    }
}
