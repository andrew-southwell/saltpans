<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (!isset($category->slug) || empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && (empty($category->slug) || !isset($category->slug))) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }
}
