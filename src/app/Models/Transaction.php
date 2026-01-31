<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

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

    public function reviews () {
        return  $this->hasMany(Review::class);
    }

    public function unreadCountFor(int $userId)
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
    }
}
