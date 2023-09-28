<?php

namespace App\Models;

use App\Trait\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory, Imageable;

    protected $guarded = [];

    public $with = ['image'];

    public static function booted()
    {
        parent::booted();

        static::creating(function ($restaurant) {
            $restaurant->slug = str()->slug($restaurant->name);
        });
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function items()
    {
        return $this->hasManyThrough(Item::class, Category::class);
    }
}
