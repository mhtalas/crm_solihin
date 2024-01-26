<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectActual extends Model
{
    use HasFactory;

    protected $guarded;

    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
