<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cuisine_id',
        'nom',
        'localisation',
        'capacite',
        'ouverture_a',
    ];

    protected function casts(): array
    {
        return [
            'ouverture_a' => 'datetime',
        ];
    }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cuisine()
    {
        return $this->belongsTo(Cuisine::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function horaires()
    {
        return $this->hasMany(Horaire::class);
    }

    public function favorisBy()
    {
        return $this->belongsToMany(User::class, 'favoris')
            ->withPivot('ajouter_favoris', 'supprimer_favoris')
            ->withTimestamps();
    }

    // Scopes pour la recherche
    public function scopeByLocalisation(Builder $query, ?string $localisation): Builder
    {
        return $localisation 
            ? $query->where('localisation', 'like', "%{$localisation}%")
            : $query;
    }

    public function scopeByCuisine(Builder $query, ?int $cuisineId): Builder
    {
        return $cuisineId 
            ? $query->where('cuisine_id', $cuisineId)
            : $query;
    }

    public function scopeByNom(Builder $query, ?string $nom): Builder
    {
        return $nom 
            ? $query->where('nom', 'like', "%{$nom}%")
            : $query;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereHas('user', function ($q) {
            $q->where('is_active', true);
        });
    }

    // Méthodes utilitaires
    public function isOpenNow(): bool
    {
        $now = now();
        $dayName = $this->getDayNameInFrench($now->dayOfWeek);
        
        $horaire = $this->horaires()
            ->where('jour_semaine', $dayName)
            ->where('statut', 'ouvert')
            ->first();

        if (!$horaire) {
            return false;
        }

        $currentTime = $now->format('H:i:s');
        return $currentTime >= $horaire->heure_ouverture 
            && $currentTime <= $horaire->heure_fermeture;
    }

    private function getDayNameInFrench(int $dayOfWeek): string
    {
        $days = [
            0 => 'Dimanche',
            1 => 'Lundi',
            2 => 'Mardi',
            3 => 'Mercredi',
            4 => 'Jeudi',
            5 => 'Vendredi',
            6 => 'Samedi',
        ];

        return $days[$dayOfWeek];
    }

    public function getPrimaryPhoto(): ?string
    {
        return $this->photos->first()?->image;
    }
}