<?php

namespace App\Models;

use App\Http\Controllers\ProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'ma_loai',
        'ten_sp',
        'donvi',
        'dongia',
    ];

    protected $table = 'products';

    public function type_product(){
        return $this->belongsTo(ProductType::class);
    }
}
