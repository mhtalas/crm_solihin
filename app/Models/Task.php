<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Task extends Model
{
    use HasFactory;

    protected $guarded;

    protected $casts = [
        'due_date' => 'date',
        'is_completed' => 'boolean',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function booted(): void
    {
        self::deleting(function (Task $customerDocument) {
            Storage::disk('public')->delete($customerDocument->file);
        });
    }
}
