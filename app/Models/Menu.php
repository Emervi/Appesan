<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $primaryKey = 'menu_id';

    protected $fillable = [
        'image',
        'name',
        'price',
        'description',
        'category',
        'stock',
    ];

    public function getFormattedPriceAttribute() {

        return 'Rp. ' . number_format($this->price, 0, ',', '.');

    }
    
}
