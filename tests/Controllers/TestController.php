<?php

namespace LaravelAdminExt\Select2\Test\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\HasResourceActions;
use LaravelAdminExt\Select2\Test\Models\Comment;
use LaravelAdminExt\Select2\Test\Models\Answer;

class TestController extends Controller
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
        return $content;
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
        $form = new Form(new Comment);

        $form->morphSelect('commentable')->type([
            Comment::class => '评论',
            Answer::class => '答案',
        ]);

        // $form->select('user_id', 'User')->match(function ($keyword) {
        //     return User::where('name', 'LIKE', '%' . $keyword . '%')->select([DB::raw('name AS text'), 'id',]);
        // })->text(function ($id) {
        //     return User::where('id', $id)->pluck('name', 'id');
        // });

        $form->textarea('content', 'Content');

        return $form;
    }
}
