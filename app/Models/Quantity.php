<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quantity extends Model
{
    use HasFactory;
    protected $table = 'quantity';
    protected $guarded = [];


    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
