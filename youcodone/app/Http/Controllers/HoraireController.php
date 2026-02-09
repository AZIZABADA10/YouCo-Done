<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Horaire;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class HoraireController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for editing horaires.
     */
    public function edit(Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);
        
        $horaires = $restaurant->horaires;
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        
        return view('horaires.edit', compact('restaurant', 'horaires', 'jours'));
    }

    /**
     * Update horaires.
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);

        $validated = $request->validate([
            'horaires' => 'required|array',
            'horaires.*.jour_semaine' => 'required|string',
            'horaires.*.statut' => 'required|in:ouvert,ferme',
            'horaires.*.heure_ouverture' => 'required_if:horaires.*.statut,ouvert',
            'horaires.*.heure_fermeture' => 'required_if:horaires.*.statut,ouvert',
        ]);

        // Supprimer les anciens horaires
        $restaurant->horaires()->delete();

        // Créer les nouveaux horaires
        foreach ($validated['horaires'] as $horaireData) {
            Horaire::create([
                'restaurant_id' => $restaurant->id,
                'jour_semaine' => $horaireData['jour_semaine'],
                'statut' => $horaireData['statut'],
                'heure_ouverture' => $horaireData['statut'] === 'ouvert' ? $horaireData['heure_ouverture'] : null,
                'heure_fermeture' => $horaireData['statut'] === 'ouvert' ? $horaireData['heure_fermeture'] : null,
            ]);
        }

        return redirect()
            ->route('restaurants.show', $restaurant)
            ->with('success', 'Horaires mis à jour avec succès !');
    }
}