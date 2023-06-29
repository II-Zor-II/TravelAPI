<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Travel extends Model
{
    use HasFactory;

    use HasSlug;

    protected $table = 'travels';

    protected $fillable = [
        'name',
        'is_public',
        'slug',
        'description',
        'number_of_days'
    ];

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class, 'travel_id', 'id');
    }

    public function numberOfNights(): Attribute
    {
        return Attribute::make(
            get: fn ($val, $attr) => $attr['number_of_days'] - 1
        );
    }
    
    public function price(): Attribute
    {
        return Attribute::make(
            get: fn ($val) => $val * 100,
            set: fn ($val) => $val * 100
        );
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

}
