<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $fillable = [
      'name',
      'description',
      'txt_description',
      'txt_description_en',
      'price',
      'category_id',
  ];
  public function image(){
    return $this->hasOne(Image::class);
  }
  public function statuse(){
    return $this->hasMany(Statuse::class)->latest('id');
  }
  public function laststatuse(){
    return $this->hasMany(Statuse::class);
  }
  public function category(){
    return $this->belongsTo(Category::class);
  }
}
