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
    ];

    public function getIsSoldAttribute()
    {
        return !is_null($this->buyer_id);
    }

}
