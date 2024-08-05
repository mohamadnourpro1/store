<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatuseName extends Model
{
    use HasFactory;
    public $fillable = [
      'name',
    ];
    public function statuse(){
      return $this->hasMany(Statuse::class);
    }
}
