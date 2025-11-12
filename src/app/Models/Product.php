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
        'is_sold',
        'condition',
        'brand',
        'description',
        'category',
    ];

    public function getConditionLabelAttribute()
{
    return match($this->condition) {
        'new', '良好' => '良好',
        'like_new', '目立った傷や汚れなし' => '目立った傷や汚れなし',
        'fair', 'やや傷や汚れあり' => 'やや傷や汚れあり',
        'poor', '状態が悪い' => '状態が悪い',
        default => '不明',
    };
}

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedBy() 
    {
        return $this->belongsToMany(User::class,'favorites', 'product_id', 'user_id')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,'category_product','product_id', 'category_id');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
