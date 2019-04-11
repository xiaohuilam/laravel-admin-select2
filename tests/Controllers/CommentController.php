<?php

namespace LaravelAdminExt\Select2\Test\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\HasResourceActions;
use LaravelAdminExt\Select2\Test\Models\Comment;
use LaravelAdminExt\Select2\Test\Models\Answer;

/**
 * A demo for morphSelect, see it in the `form()` method
 */
class CommentController extends Controller
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
        $form = new Form(new Comment);

        $form->morphSelect('commentable', 'Comment on')->type([
            Comment::class => 'Comment',
            Answer::class => 'Answer',
        ]);

        $form->textarea('content', 'Content');

        return $form;
    }
}
