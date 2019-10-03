<?php

namespace ktourvas\LaravelBlog\Entities;

use Illuminate\Database\Eloquent\Model;

class ArticleBody extends Model {

    protected $fillable = [ 'body', 'article_id' ];

    protected $table = 'lb_article_bodies';

    public function article() {
        return $this->belongsTo('ktourvas\LaravelBlog\Entities\Article', 'article_id');
    }

}
