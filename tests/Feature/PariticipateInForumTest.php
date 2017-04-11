<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PariticipateInForum extends TestCase
{

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

	/** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();

        $reply = make('App\Reply');

        $this->post($this->thread->path.'/replies', $reply->toArray());

        $this->get($this->thread->path)
        	->assertSee($reply->body);
    }

	/** @test */
    public function guests_may_not_add_replies()
    {

    	$this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post($this->thread->path.'/replies', []);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->signIn()->expectException('Illuminate\Validation\ValidationException');

        $reply = make('App\Reply', ['body' => null]);

        $this->post($this->thread->path.'/replies', $reply->toArray());
    }
}
