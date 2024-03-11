<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Posts extends Model
{
    use HasFactory;
    use HasSlug;

    public function getSlugOptions():SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom("post_description")->saveSlugsTo('slug');
    }

    public function getRouteKeyName(){
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        $now = date('Y-m-d');
        return $query->where([
            ['post_status','=','Publish'],
        ['post_publish_date','<=',$now]]);
    }



    protected $fillable=[
        'post_title',
        'post_description',
        'post_publish_date',
        'post_status',
    ];

    protected $casts = [
        'post_publish_date' => 'datetime',
        'post_title' => 'array',
    ];

    protected $attributes = [
        'is_deleted' => false,
    ];

}
