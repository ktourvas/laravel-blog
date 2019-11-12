<?php

namespace ktourvas\LaravelBlog\Entities;

use Illuminate\Database\Eloquent\Model;
use ktourvas\LaravelMediable\Entities\Mediable;
//use ktourvas\LaravelSeoable\Entities\Seoable;

class Article extends Model {

    use Mediable;
//        Seoable;

    protected $fillable = [ 'slug', 'user_id' ];

    protected $table = 'lb_articles';

    public function titles() {
        return $this->hasMany('ktourvas\LaravelBlog\Entities\ArticleTitle', 'article_id');
    }

    public function body() {
        return $this->hasOne('ktourvas\LaravelBlog\Entities\ArticleBody', 'article_id');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
//    public function getRouteKeyName()
//    {
//        return 'slug';
//    }

}
