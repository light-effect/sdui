<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use DatabaseMigrations;

    private Collection $news;

    public function setUp(): void
    {
        parent::setUp();
        /** @var Authenticatable $user */
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $this->news = News::factory()->count(5)->create();
    }

    public function testGetAllNews(): void
    {
        $response = $this->get('/api/news');

        $response->assertOk();
        $response->assertSee($this->news[0]->title);
    }

    public function testGetNewsById(): void
    {


        $response = $this->get('/api/news/' . $this->news[1]->id);

        $response->assertOk();
        $response->assertSee($this->news[1]->title);
    }

    public function testPostNews()
    {
        /** @var Authenticatable $user */

        $news = News::factory()->make();

        $response = $this->post('/api/news', $news->toArray());

        $response->assertCreated();
        $response->assertSee($news->title);
        $response->assertSee($news->content);
    }

    public function testPostNewsWithWrongData()
    {

        $response = $this->post('/api/news', [
            'data' => 'test'
        ]);

        $response->assertStatus(400);
    }

    public function testUpdateNews()
    {
        $response = $this->put('/api/news/' . $this->news[0]->id, [
            'title' => 'Test title'
        ]);

        $response->assertOk();
        $response->assertSee('Test title');
        $response->assertSee($this->news[0]->content);
    }

    public function testDeleteNewsById()
    {
        $response = $this->delete('/api/news/' . $this->news[0]->id);

        $response->assertNoContent();
    }
}
