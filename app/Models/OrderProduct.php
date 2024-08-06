<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;
    public $fillable = [
      'order_id',
      'name',
      'price',
      'id_product',
    ];
    public function order(){
      return $this->belongsTo(Order::class);
    }
}
