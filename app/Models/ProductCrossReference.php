<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCrossReference extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'part_number',
        'company_name',
    ];
}
