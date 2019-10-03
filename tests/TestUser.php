<?php

namespace Tests;

use Illuminate\Foundation\Auth\User;
use ktourvas\LaravelBlog\Entities\HasArticles;

class TestUser extends User {
    use HasArticles;
}