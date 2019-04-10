<?php

namespace LaravelAdminExt\Select2\Test;

use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\DB;
use LaravelAdminExt\Select2\Test\Models\Comment;
use LaravelAdminExt\Select2\Test\Models\Answer;

class MatchApiTest extends TestCase
{
    /**
     * 测试表单
     *
     * @return void
     */
    public function testPing()
    {
        $url = '/ping';
        $response = $this->get($url)->response;

        $this->assertEquals('pong', $response->getOriginalContent());
    }

    /**
     * 测试表单
     *
     * @return void
     */
    public function testForm()
    {
        $answer = new Answer();
        $answer->content = 'test';
        $answer->user_id = mt_rand(1, 10);
        $answer->save();

        $id = mt_rand(1, 1000);

        $comment = new Comment();
        $comment->id = $id;
        $comment->content = mt_rand(0, 100);
        $comment->user_id = mt_rand(1, 10);
        $comment->commentable()->associate($answer);
        $comment->save();

        $url = '/admin/test/' . $id;
        $response = $this->get($url)->response;

        $res = $response->getOriginalContent();
        echo $res;
        $this->assertEquals(200, $response->getStatusCode());
    }
}
