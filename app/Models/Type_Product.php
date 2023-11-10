<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'ten_loai',
        'ma_ncc'
    ];
    protected $table = 'type_product';

    public function product()
    {
        return $this->hasMany(Product::class, 'ma_loai', 'ma_loai');
    }
}
