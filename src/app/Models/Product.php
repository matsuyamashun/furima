<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'image_url',
        'user_id',
        'price',
        'condition',
        'brand',
        'description',
        'category',
    ];

    public function getIsSoldAttribute()
    {
        return !is_null($this->buyer_id);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

}
