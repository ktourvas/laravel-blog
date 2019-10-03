<?php

namespace ktourvas\LaravelBlog\Entities;

use Illuminate\Database\Eloquent\Model;

class ArticleTitle extends Model {

    protected $fillable = [ 'article_id', 'type_id', 'title' ];

    protected $table = 'lb_article_titles';

    public function article() {
        return $this->belongsTo('ktourvas\LaravelBlog\Entities\Article', 'article_id');
    }

}
