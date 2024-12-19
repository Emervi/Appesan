<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'customer_id',
        'menu_id',
        'receipt_code',
        'order_date',
        'total_price',
        'status',
    ];

    public function detailOrders(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }

}
