<?php

namespace ktourvas\LaravelBlog\Entities\Policies;

use Illuminate\Foundation\Auth\User;
use ktourvas\LaravelBlog\Entities\Article;

class ArticlePolicy
{

    public function __construct() {

    }

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Article $article)
    {
        return true;
    }

    public function create(User $user, Article $article)
    {
        return true;
    }

    public function update(User $user, Article $article)
    {

        return $article->user_id == $user->id;

    }

    public function delete(User $user, Article $article)
    {
        return $article->user_id == $user->id;
    }

    public function restore(User $user, Article $article)
    {
        return $article->user_id == $user->id;
    }

    public function forceDelete(User $user, Article $article)
    {
        return $article->user_id == $user->id;
    }

}