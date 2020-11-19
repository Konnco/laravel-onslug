<?php

namespace Konnco\OnSlug;

use Illuminate\Support\Str;

trait OnSlug
{
    public function onSlugField()
    {
        return "name";
    }

    public static function bootOnSlug()
    {
        static::creating(function ($model) {
            $slug = Str::slug($model->{$model->slugKey()});
            $count = 2;
            recheck_slug:
            $exist = self::where('slug', $slug)->count();
            if ($exist) {
                $slug = Str::slug($model->{$model->slugKey()} . "-" . $count);
                $count++;
                goto recheck_slug;
            } else {
                $model->slug = $slug;
                return $model;
            }
        });
    }
}
