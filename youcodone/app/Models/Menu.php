<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'plat_id',
    ];


    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function plats()
    {
        return $this->hasMany(Plat::class);
    }

    public function getTotalPrice(): float
    {
        return $this->plats()->sum('prix_unit');
    }
}