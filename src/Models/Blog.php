<?php

namespace Dealskoo\Blog\Models;

use Dealskoo\Comment\Traits\Commentable;
use Dealskoo\Country\Traits\HasCountry;
use Dealskoo\Tag\Traits\Taggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    use HasFactory, HasCountry, Taggable, Commentable, SoftDeletes;

    protected $appends = [
        'cover_url'
    ];

    protected $fillable = [
        'slug',
        'title',
        'cover',
        'content',
        'published_at',
        'can_comment',
        'country_id'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'can_comment' => 'boolean',
    ];

    public function getCoverUrlAttribute()
    {
        return empty($this->cover) ? '' : Storage::url($this->cover);
    }
}
