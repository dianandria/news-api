<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\News;

class NewsTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_store_news()
    {
    	$data = ([
        	'news_category_id' => 1,
            'title' => 'Unit Test Store',
            'short_description' => 'Unit Test Store',
            'full_content' => "Unit Test Store",
            'thumbnail' => 'https://via.placeholder.com/400',
            'thumbnail_caption' => 'Thumbnail caption',
            'is_publish' => 1,
        ]);

        $this->post(route('news.store'), $data)->assertStatus(201);
    }

    public function test_show_news()
    {
        $this->get(route('news.index'))
            ->assertStatus(200);
    }

    public function test_get_news()
    {
    	$id = News::latest()->first()->id;

        $this->get(route('news.show', $id))
            ->assertStatus(200);
    }

    public function test_update_news()
    {
        $id = News::latest()->first()->id;

        $data = ([
            'news_category_id' => 1,
            'title' => 'Unit Test Update',
            'short_description' => 'Unit Test Update',
            'full_content' => "Unit Test Update",
            'thumbnail' => 'https://via.placeholder.com/400',
            'thumbnail_caption' => 'Thumbnail caption update',
            'is_publish' => 1,
        ]);

        $this->put(route('news.update', $id), $data)->assertStatus(201);
    }

    public function test_delete_news()
    {
    	$id = News::latest()->first()->id;
    	$this->delete(route('news.destroy', $id))
            ->assertStatus(204);
    }
}
