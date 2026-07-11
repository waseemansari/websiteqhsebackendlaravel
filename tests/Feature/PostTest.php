<?php

use App\Models\Post;
use App\Models\User;

test('user can view and update an existing post', function () {
    $user = User::factory()->create(['branch_id' => 'branch-1']);

    $post = Post::create([
        'title' => 'Original title',
        'slug' => 'original-title',
        'content' => 'Original body',
        'status' => 'draft',
        'branch_id' => 'branch-1',
    ]);

    $editResponse = $this
        ->actingAs($user)
        ->get("/post/{$post->id}/edit");

    $editResponse->assertOk()->assertSee('Original title');

    $updateResponse = $this
        ->actingAs($user)
        ->put("/post/{$post->id}", [
            'title' => 'Updated title',
            'slug' => 'updated-title',
            'content' => 'Updated body',
            'status' => 'published',
            'branch_id' => 'branch-1',
        ]);

    $updateResponse
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('post.index'));

    $post->refresh();

    expect($post->title)->toBe('Updated title')
        ->and($post->content)->toBe('Updated body')
        ->and($post->status)->toBe('published');
});
