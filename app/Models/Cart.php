<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id'];

    // Mối quan hệ với CartItem
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
