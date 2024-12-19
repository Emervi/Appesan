<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'menu_id',
        'quantity',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    // Aksesori untuk mendapatkan harga dengan format 'Rp. '
    public function getFormattedPriceAttribute()
    {
        return 'Rp. ' . number_format($this->price, 0, ',', '.');
    }

}
