<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_create_page()
    {
        $response = $this->get(route('posts.create'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_create_post()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
             ->post(route('posts.store'), [
                 'title' => 'Judul Test',
                 'body' => 'Isi test post',
             ])
             ->assertRedirect(route('posts.index'));

        $this->assertDatabaseHas('posts', ['title' => 'Judul Test']);
    }

    public function test_user_can_edit_own_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create(['title' => 'Lama']);

        $this->actingAs($user)
             ->put(route('posts.update', $post), [
                 'title' => 'Baru',
                 'body' => $post->body,
             ])
             ->assertRedirect();

        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Baru']);
    }

    public function test_user_cannot_edit_others_post()
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $post = Post::factory()->for($owner)->create(['title' => 'Original']);

        $this->actingAs($other)
             ->put(route('posts.update', $post), [
                 'title' => 'Hacked',
                 'body' => $post->body,
             ]);

        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Original']);
    }
}
