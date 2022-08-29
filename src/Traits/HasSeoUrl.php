<?php

namespace Dealskoo\Blog\Traits;

use Illuminate\Support\Str;

trait HasSeoUrl
{
    public function setSeoUrlAttribute($value)
    {
        $this->attributes['seo_url'] = Str::lower($value);
    }

    public function getSeoUrlRouteKey()
    {
        return $this->seo_url ?? $this->getKey();
    }

    public function scopeFindBySeoUrl($query, $seo_url)
    {
        return $query->where('seo_url', $seo_url)->orWhere('seo_url', $seo_url);
    }
}
