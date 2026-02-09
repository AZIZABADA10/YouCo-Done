<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'jour_semaine',
        'heure_ouverture',
        'heure_fermeture',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'heure_ouverture' => 'datetime:H:i',
            'heure_fermeture' => 'datetime:H:i',
        ];
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function isOpen(): bool
    {
        return $this->statut === 'ouvert';
    }

    public function getFormattedHours(): string
    {
        if ($this->statut === 'ferme') {
            return 'Fermé';
        }

        return sprintf(
            '%s - %s',
            $this->heure_ouverture->format('H:i'),
            $this->heure_fermeture->format('H:i')
        );
    }
}