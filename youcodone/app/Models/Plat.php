<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plat extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'content',
        'prix_unit',
 
    ];

    protected function casts(): array
    {
        return [
            'prix_unit' => 'decimal:2',
        ];
    }


    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->prix_unit, 2) . ' DH';
    }
}