<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Tests\BaseTestCase;
use Illuminate\Http\UploadedFile;


class ArticlesControllerTest extends BaseTestCase
{

    public function testCreateEdit() {

//        $this->withoutExceptionHandling();

        $this->setAttributes();

        $response = $this->postJson('/api/blog', $this->attributes);

        $response->assertStatus(401);

        $response = $this->putJson('/api/blog/1', $this->attributes);

        $response->assertStatus(401);

        $response = $this->actingAs($this->user, 'api')
            ->postJson('/api/blog', $this->attributes);

        $response->assertStatus(201);

        $this->assertDatabaseHas('lb_articles', compact( $this->attributes['slug'] ));

        $this->assertDatabaseHas('lb_article_bodies', compact( $this->attributes['body'] ));

        foreach ($this->attributes['titles'] as $title) {
            $this->assertDatabaseHas('lb_article_titles', [ 'type_id' => $title['type_id'], 'title' => $title['payload'] ] );
        }

        $response = $this->get('/api/blog');
//        dd($response);

        foreach ($this->attributes['titles'] as $title) {
            $response->assertSee( $title['payload'] );
        }

        $response = $this->get('/api/blog/1');
//        dd($response);

        foreach ($this->attributes['titles'] as $title) {
            $response->assertSee( $title['payload'] );
        }

        $this->setAttributes();

        $response = $this->actingAs($this->user, 'api')
            ->putJson('/api/blog/1', $this->attributes);

        $response->assertStatus(200);

        $response = $this->get('/api/blog/1');

        foreach ($this->attributes['titles'] as $title) {
            $response->assertSee( $title['payload'] );
        }

        $response->assertStatus(200);

        $this->get('/api/blog/1')->assertSee($this->attributes['slug']);

        $this->get('/api/blog/1')->assertSee($this->attributes['body']);

        $response = $this->actingAs($this->user, 'api')
            ->putJson('/api/blog/1/media', [
                'gallery' => UploadedFile::fake()->image('avatar.jpg')
            ]);

        $response->assertStatus(200);

        $response = $this->get('/api/blog/1');

        $response ->assertSee('media');

        foreach ( json_decode( $response ->getContent())->media as $mediaObject ) {

            $this->assertTrue( Storage::exists( $mediaObject->path ) );

        }

    }

    private function setAttributes() {
        $this->attributes = [
            'slug' => $this->faker->slug,
            'body' => $this->faker->paragraph,
        ];

        $this->attributes['titles'] = config('laravel-blog.titles');

        foreach ( config('laravel-blog.titles') as $title ) {

            $this->attributes['titles'][$title['name']]['payload'] = $this->faker->sentence;

        }
    }

}