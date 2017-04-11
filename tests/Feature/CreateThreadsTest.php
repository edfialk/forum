<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CreateThreadsTest extends TestCase
{


    /** @test */
    public function guests_may_not_create_threads()
    {

    	$this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray());
    }

    /** @test */
    public function guests_cannot_see_create_thread_page()
    {

    	$this->expectException('Illuminate\Auth\AuthenticationException');

        $this->get('/threads/create');
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();


        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
        	->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->signIn()->expectException('Illuminate\Validation\ValidationException');

        $thread = make('App\Thread', ['title' => null]);

        $this->post('/threads', $thread->toArray());
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->signIn()->expectException('Illuminate\Validation\ValidationException');

        $thread = make('App\Thread', ['body' => null]);

        $this->post('/threads', $thread->toArray());
    }

    /** @test */
    public function a_thread_requires_a_channel()
    {

        $this->signIn()->expectException('Illuminate\Validation\ValidationException');

        $thread = make('App\Thread', ['channel_id' => null]);

        $this->post('/threads', $thread->toArray());
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {

        $this->signIn()->expectException('Illuminate\Validation\ValidationException');

        $thread = make('App\Thread', ['channel_id' => 'abcd']);

        $this->post('/threads', $thread->toArray());
    }
}
