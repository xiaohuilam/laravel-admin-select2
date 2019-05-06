<?php

namespace LaravelAdminExt\Select2\Test;

use LaravelAdminExt\Select2\Test\Models\Answer;
use LaravelAdminExt\Select2\Test\Models\Question;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SelectApiTest extends AbstractTestCase
{
    use Menu;
    protected $url = '/answer/55/edit';

    public function setUp()
    {
        $this->__init();

        $question = new Question();
        $question->id = 101;
        $question->title = 'test';
        $question->save();

        $answer = new Answer();
        $answer->id = 55;
        $answer->content = mt_rand(0, 100);
        $answer->question()->associate($question);
        $answer->save();
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

        $this->seeInElement('.col-sm-8', 'name="question_id" data-value="101"');
    }

    /**
     * 断言match api
     */
    public function testMatch()
    {
        $url = $this->url . '?' . http_build_query([
            'search' => 'question_id',
            'value' => 101,
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
        $this->assertEquals('101', $list->pluck('id')->implode(''));
    }

    /**
     * 断言text api
     */
    public function testText()
    {
        $url = $this->url . '?' . http_build_query([
            'retrive' => 'question_id',
            'value' => 101,
        ]);

        $response = $this->get($url)->response;

        $this->assertEquals(200, $response->getStatusCode());

        /**
         * @var Collection $data
         */
        $data = $response->getOriginalContent();
        $this->assertInstanceOf(Collection::class, $data);
        $this->assertEquals(['101' => 'test',], $data->toArray());
    }
}
