<?php

namespace Hazzard\Comments\Tests;

use Hazzard\Comments\Vote;
use Hazzard\Comments\Comment;

class VoteApiTest extends TestCase
{
    /** @test */
    public function it_can_upvote_a_comment()
    {
        $comment = factory(Comment::class)->create(['user_id' => $this->testUser->id]);

        $this->actingAs($this->testUser)
            ->json('POST', "/comments/{$comment->id}/upvote")
            ->assertStatus(204);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'upvotes' => 1,
        ]);

        $this->assertDatabaseHas('comment_votes', [
            'comment_id' => 1,
            'user_id' => $this->testUser->id,
            'type' => 'up',
        ]);
    }

    /** @test */
    public function it_can_downvote_a_comment()
    {
        $comment = factory(Comment::class)->create(['user_id' => $this->testUser->id]);

        $this->actingAs($this->testUser)
            ->json('POST', "/comments/{$comment->id}/downvote")
            ->assertStatus(204);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'downvotes' => 1,
        ]);

        $this->assertDatabaseHas('comment_votes', [
            'comment_id' => 1,
            'user_id' => $this->testUser->id,
            'type' => 'down',
        ]);
    }

    /** @test */
    public function it_can_remove_a_comment_vote()
    {
        $comment = factory(Comment::class)->create([
            'user_id' => $this->testUser->id,
            'upvotes' => 2,
        ]);

        $comment->votes()->save(new Vote([
            'type' => 'up',
            'user_id' => $this->testUser->id,
        ]));

        $this->actingAs($this->testUser)
            ->json('DELETE', "/comments/{$comment->id}/remove-vote")
            ->assertStatus(204);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'upvotes' => 1,
        ]);

        $this->assertDatabaseMissing('comment_votes', [
            'comment_id' => $comment->id,
            'user_id' => $this->testUser->id,
            'type' => 'up',
        ]);
    }

    /** @test */
    public function it_can_not_upvote_a_comment_multiple_times()
    {
        $comment = factory(Comment::class)->create(['user_id' => $this->testUser->id]);

        $this->actingAs($this->testUser)
            ->json('POST', "/comments/{$comment->id}/upvote")
            ->assertStatus(204);

        $this->actingAs($this->testUser)
            ->json('POST', "/comments/{$comment->id}/upvote")
            ->assertStatus(204);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'upvotes' => 1,
        ]);

        $this->assertDatabaseHas('comment_votes', [
            'comment_id' => $comment->id,
            'user_id' => $this->testUser->id,
            'type' => 'up',
        ]);
    }

    /** @test */
    public function it_can_change_an_upvote_into_a_downvote()
    {
        $comment = factory(Comment::class)->create(['user_id' => $this->testUser->id]);

        $this->actingAs($this->testUser)
            ->json('POST', "/comments/{$comment->id}/upvote");

        $this->actingAs($this->testUser)
            ->json('POST', "/comments/{$comment->id}/downvote")
            ->assertStatus(204);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'upvotes' => 0,
            'downvotes' => 1,
        ]);

        $this->assertDatabaseHas('comment_votes', [
            'comment_id' => $comment->id,
            'user_id' => $this->testUser->id,
            'type' => 'down',
        ]);
    }

    /** @test */
    public function it_can_change_a_downvote_into_an_upvote()
    {
        $comment = factory(Comment::class)->create(['user_id' => $this->testUser->id]);

        $this->actingAs($this->testUser)
            ->json('POST', "/comments/{$comment->id}/downvote");

        $this->actingAs($this->testUser)
            ->json('POST', "/comments/{$comment->id}/upvote")
            ->assertStatus(204);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'upvotes' => 1,
            'downvotes' => 0,
        ]);

        $this->assertDatabaseHas('comment_votes', [
            'comment_id' => $comment->id,
            'user_id' => $this->testUser->id,
            'type' => 'up',
        ]);
    }

    /** @test */
    public function it_can_not_vote_if_is_a_guest()
    {
        $comment = factory(Comment::class)->create(['user_id' => $this->testUser->id]);

        $this->json('POST', "/comments/{$comment->id}/upvote")
            ->assertStatus(401);
    }
}
