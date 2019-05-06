<?php

namespace LaravelAdminExt\Select2\Test;

use LaravelAdminExt\Select2\Test\Models\Comment;
use LaravelAdminExt\Select2\Test\Models\Answer;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class MorphSelectApiTest extends AbstractTestCase
{
    use Menu;
    protected $url = '/comment/100/edit';

    public function setUp()
    {
        $this->__init();

        $answer = new Answer();
        $answer->content = 'test';
        $answer->question_id = 1;
        $answer->save();

        $id = 100;

        $comment = new Comment();
        $comment->id = $id;
        $comment->content = mt_rand(0, 100);
        $comment->commentable()->associate($answer);
        $comment->save();
    }

    /**
     * 断言表单
     */
    public function testForm()
    {
        $url = $this->url;
        $response = $this->get($url)->response;

        $this->assertEquals(200, $response->getStatusCode());

        // check is permission okay
        $this->assertFalse(Str::contains($response, 'Permission Denied'));

        $this->seeInElement('[name="commentable_type"]', Comment::class);
        $this->seeInElement('[name="commentable_type"]', Answer::class . '" selected');

        $this->seeInElement('.col-sm-6', 'name="commentable_id" data-value="1"');
    }

    /**
     * 断言match api
     */
    public function testMatch()
    {
        $url = $this->url . '?' . http_build_query([
            'search' => 'commentable_id',
            'morph_type' => Answer::class,
            'value' => 1,
        ]);

        $response = $this->get($url)->response;

        $this->assertEquals(200, $response->getStatusCode());

        /**
         * @var LengthAwarePaginator $data
         */
        $data = $response->getOriginalContent();
        $this->assertInstanceOf(LengthAwarePaginator::class, $data);

        $list = $data->getCollection();

        $this->assertEquals('test', $list->pluck('text')->implode(''));
        $this->assertEquals('1', $list->pluck('id')->implode(''));
    }

    /**
     * 断言text api
     */
    public function testText()
    {
        $url = $this->url . '?' . http_build_query([
            'retrive' => 'commentable_id',
            'morph_type' => Answer::class,
            'value' => 1,
        ]);

        $response = $this->get($url)->response;

        $this->assertEquals(200, $response->getStatusCode());

        /**
         * @var Collection $data
         */
        $data = $response->getOriginalContent();
        $this->assertInstanceOf(Collection::class, $data);
        $this->assertEquals(['1' => 'test', ], $data->toArray());
    }
}
