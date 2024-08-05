<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    public $fillable = [
      'product_id',
      'image1',
      'image2',
      'video',
    ];
    public function product(){
      return $this->belongsTo(Product::class);
    }
}
