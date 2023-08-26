<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function booted(){
        parent::booted();

        static::creating(function($restaurant){
            $restaurant->slug = str()->slug($restaurant->name);
        });
    }
}
