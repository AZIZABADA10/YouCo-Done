<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Relations
    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    public function favoris()
    {
        return $this->belongsToMany(Restaurant::class, 'favoris')
            ->withPivot('ajouter_favoris', 'supprimer_favoris')
            ->withTimestamps();
    }

    public function isRestaurateur(): bool
    {
        return $this->hasRole('restaurateur');
    }

    public function isClient(): bool
    {
        return $this->hasRole('client');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function hasFavorite(Restaurant $restaurant): bool
    {
        return $this->favoris()->where('restaurant_id', $restaurant->id)->exists();
    }
}