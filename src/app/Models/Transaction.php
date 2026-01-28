<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'product_id',
        'seller_id',
        'buyer_id',
        'status',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function seller() {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function buyer() {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }
}
