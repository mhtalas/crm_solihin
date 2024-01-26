<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;
    protected $guarded;

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function branch() : BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function isAdmin(): bool
    {
        return $this->is_complete === true;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        $user = \Auth::user();
        if ($user->roles()->count() !== 0 ){
            return true;
        }else{
            return false;
        }
//        return $this->hasRole(['Super Admin', 'Admin', 'User','Sales', 'Admin Marketing']);
    }

    public function customers() : HasMany
    {
        return $this->hasMany(Customer::class,'employee_id');
    }

}
