<?php

namespace LaravelAdminExt\Select2\Test;

use LaravelAdminExt\Select2\Test\Models\Tag;
use LaravelAdminExt\Select2\Test\Models\Question;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class MultipleSelectApiTest extends AbstractTestCase
{
    use Menu;
    protected $url = '/question/66/edit';

    public function setUp()
    {
        $this->__init();

        $question = new Question();
        $question->id = 66;
        $question->title = 'test';
        $question->save();

        $tags = collect([]);
        for ($i = 1; $i < 6; $i++) {
            $tag = new Tag();
            $tag->name = 'tag ' . $i;
            $tags->push($tag);
        }

        $question->tags()->saveMany($tags);
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

        $this->seeInElement('.col-sm-8', 'data-value="1,2,3,4,5"');
    }

    /**
     * 断言match api
     */
    public function testMatch()
    {
        $url = $this->url . '?' . http_build_query([
            'search' => 'tags',
            'keyword' => 'tag',
        ]);

        $response = $this->get($url)->response;

        $this->assertEquals(200, $response->getStatusCode());

        /**
         * @var LengthAwarePaginator $data
         */
        $data = $response->getOriginalContent();
        $this->assertInstanceOf(LengthAwarePaginator::class, $data);

        $list = $data->getCollection();

        $this->assertEquals('tag 1,tag 2,tag 3,tag 4,tag 5', $list->pluck('text')->sort()->implode(','));
        $this->assertEquals('1,2,3,4,5', $list->pluck('id')->sort()->implode(','));
    }

    /**
     * 断言text api
     */
    public function testText()
    {
        $url = $this->url . '?' . http_build_query([
            'retrive' => 'tags',
            'value' => 1,
        ]);

        $response = $this->get($url)->response;

        $this->assertEquals(200, $response->getStatusCode());

        /**
         * @var Collection $data
         */
        $data = $response->getOriginalContent();
        $this->assertInstanceOf(Collection::class, $data);
        $this->assertEquals(['1' => 'tag 1',], $data->toArray());
    }
}
