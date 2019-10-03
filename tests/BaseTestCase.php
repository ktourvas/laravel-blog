<?php

namespace Tests;

use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase;


class BaseTestCase extends TestCase
{

    use WithFaker, RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            'ktourvas\LaravelBlog\LaravelBlogServiceProvider',
            'ktourvas\LaravelMediable\LaravelMediableServiceProvider'
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app) {
        $app['config']->set('laravel-blog', include __DIR__.'/../config/laravel-blog.php' );
    }

    protected function setUp() : void
    {
        parent::setUp();

        $this->user = new TestUser();

        $this->user->id = $this->faker->randomNumber();
        $this->user->name = $this->faker->name;
        $this->user->email = $this->faker->unique()->safeEmail;
        $this->user->email_verified_at = now();
        $this->user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password
        $this->user->remember_token = Str::random(10);


    }

}