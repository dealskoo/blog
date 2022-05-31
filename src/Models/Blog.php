<?php

namespace Dealskoo\Blog\Models;

use Dealskoo\Admin\Traits\HasSlug;
use Dealskoo\Comment\Traits\Commentable;
use Dealskoo\Country\Traits\HasCountry;
use Dealskoo\Tag\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Blog extends Model
{
    use HasFactory, HasSlug, HasCountry, Taggable, Commentable, SoftDeletes, Searchable;

    protected $appends = [
        'cover_url',
        'summary'
    ];

    protected $fillable = [
        'slug',
        'title',
        'cover',
        'content',
        'published_at',
        'can_comment',
        'views',
        'country_id'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'can_comment' => 'boolean',
    ];

    public function getCoverUrlAttribute()
    {
        return empty($this->cover) ? asset(config('blog.default_cover')) : Storage::url($this->cover);
    }

    public function scopePublished(Builder $builder)
    {
        return $builder->whereNotNull('published_at');
    }

    public function getSummaryAttribute()
    {
        return Str::limit(strip_tags(Str::markdown($this->content)), 100);
    }

    public function toSearchableArray()
    {
        return $this->only([
            'slug',
            'title',
            'content',
            'country_id'
        ]);
    }
}
