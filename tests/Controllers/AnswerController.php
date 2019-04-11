<?php

namespace LaravelAdminExt\Select2\Test\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\HasResourceActions;
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
}
