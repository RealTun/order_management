<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_details extends Model
{
    use HasFactory;
    protected $table = "order_details";
    public $timestamps = false;
    protected $fillable = [
        "ma_hoadon",
        "ma_sp",
        "soluong",
    ];
}
