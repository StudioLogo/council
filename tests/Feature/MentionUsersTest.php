<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        // Given I have a user, JohnDoe, who is signed in.
        $john = create(User::class, ['name' => 'JohnDoe']);

        $this->signIn($john);

        // And another user, Smith.
        $smith = create(User::class, ['name' => 'Smith']);

        // If we have a thread
        $thread = create('App\Thread');

        // And JohnDoe replies and mentions @Smith.
        $reply = make('App\Reply', [
            'body' => '@Smith look at this. Also @FrankDoe.',
        ]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        // Then, Smith should be notified.
        $this->assertCount(1,$smith->notifications);
    }

    /** @test */
    public function it_can_fetch_all_mentioned_users_starting_with_the_given_characters()
    {
        create(User::class, ['name' => 'John Doe']);
        create(User::class, ['name' => 'Jane Doe']);
        create(User::class, ['name' => 'johndoe2']);

        $response = $this->json('get', '/api/users', ['name' => 'john'])
            ->assertSee('John Doe');

        $this->assertCount(2, $response->json());


    }
}
