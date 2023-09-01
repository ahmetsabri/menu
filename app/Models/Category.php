<?php

namespace App\Models;

use App\Trait\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory, Imageable;

    protected $guarded = [];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function items(){
        return $this->hasMany(Item::class);
    }

    public static function booted(){
        parent::booted();
        static::deleting(function($category){
            $category->image ? Storage::delete($category?->image?->path ?? '') : '';
            $category->image?->delete();
        });
    }
}
