<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statuse extends Model
{
    use HasFactory;
    public $fillable = [
      'statuse_name_id',
      'product_id',
    ];
    public function product(){
      return $this->belongsTo(Product::class);
    }
    public function statuse_name(){
      return $this->belongsTo(StatuseName::class);
    }
}
