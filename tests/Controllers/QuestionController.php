<?php

namespace LaravelAdminExt\Select2\Test\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use LaravelAdminExt\Select2\Test\Models\Tag;
use LaravelAdminExt\Select2\Test\Models\Question;

/**
 * A demo for multipleSelect, see it in the `form()` method
 */
class QuestionController extends Controller
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
        $form = new Form(new Question);

        $form->textarea('title', 'Title');

        $form->multipleSelect('tags')->match(function ($keyword) {
            return Tag::where('name', 'LIKE', '%' . $keyword . '%')

                // because select2 js plugin needs `text` and `id` column,
                // so if your model does not contains these two, remember to AS for them
                ->select([DB::raw('name AS text'), 'id',])
                ->latest();
        })->text(function ($id) {
            // return type is `{id1: text1, id2: text2...}
            return Tag::whereIn('id', $id)->pluck('name', 'id');
        });

        return $form;
    }
}
