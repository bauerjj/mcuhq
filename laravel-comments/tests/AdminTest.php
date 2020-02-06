<?php

namespace Hazzard\Comments\Tests;

use DB;
use Hazzard\Comments\Comment;
use Illuminate\Support\Facades\Gate;
use Hazzard\Comments\ScriptVariables;

class AdminTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Gate::define('moderate-comments', function ($user) { return true; });
    }

    /** @test */
    public function it_can_show_the_show_the_dashboard_page()
    {
        $this->actingAs($this->testUser)
            ->get('/comments/admin')
            ->assertStatus(200);

        $args = ScriptVariables::get('data.args');
        $comments = ScriptVariables::get('data.comments');

        $this->assertInternalType('array', $args);
        $this->assertInternalType('array', $comments);
    }

    /** @test */
    public function it_can_fetch_comments()
    {
        factory(Comment::class, 2)->create(['page_id' => 1]);
        factory(Comment::class, 2)->create(['page_id' => 2]);

        $response = $this->actingAs($this->testUser)
            ->json('GET', '/comments/admin')
            ->assertStatus(200);

        $this->assertCount(4, $response->json()['comments']);
    }

    /** @test */
    public function it_can_show_the_show_the_settings_page()
    {
        $this->actingAs($this->testUser)
            ->get('/comments/admin/settings')
            ->assertStatus(200)
            ->assertViewHas('tabs');
    }

    /** @test */
    public function it_can_update_the_settings()
    {
        $this->actingAs($this->testUser)
            ->json('POST', '/comments/admin/settings', [
                'allow_guests' => '1',
                'allow_votes' => '0',
                'allow_edit' => '10',
                'allow_delete' => '',
                'default_order' => 'best',
                'censored_words' => "word1\nword2\nword3",
                'admin_notification' => 'admin@example.com',
            ])
            ->assertStatus(204);

        $settings = app('comments.settings');

        $this->assertTrue($settings->get('allow_guests'));
        $this->assertFalse($settings->get('allow_votes'));
        $this->assertEquals(10, $settings->get('allow_edit'));
        $this->assertEquals(0, $settings->get('allow_delete'));
        $this->assertEquals('best', $settings->get('default_order'));
        $this->assertCount(3, $settings->get('censored_words'));
        $this->assertEquals('admin@example.com', $settings->get('admin_notification'));
    }

    /** @test */
    public function it_can_reset_the_settings()
    {
        DB::table('comment_settings')->insert([
            'key' => 'allow_guests',
            'value' => 'b:0;'
        ]);

        $this->actingAs($this->testUser)
            ->json('DELETE', '/comments/admin/settings')
            ->assertStatus(204);

        $this->assertDatabaseMissing('comment_settings', [
            'allow_guests' => 'b:0;'
        ]);
    }
}
