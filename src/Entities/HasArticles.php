<?php

namespace ktourvas\LaravelBlog\Entities;

trait HasArticles {

    public function articles() {
        return $this->hasMany('ktourvas\LaravelBlog\Entities\Article', 'user_id');
    }

}