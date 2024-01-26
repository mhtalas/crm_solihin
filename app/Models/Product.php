<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $guarded;

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(ProductItem::class,'product_package');
    }
}
