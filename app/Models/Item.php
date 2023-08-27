<?php

namespace App\Models;

use App\Trait\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory, Imageable;

    protected $guarded = [];
}
