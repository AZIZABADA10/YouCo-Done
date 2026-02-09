<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class FavoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Afficher tous les favoris de l'utilisateur
     */
    public function index()
    {
        $favoris = auth()->user()
            ->favoris()
            ->with(['cuisine', 'photos'])
            ->latest('favoris.created_at')
            ->paginate(12);

        return view('favoris.index', compact('favoris'));
    }

    /**
     * Ajouter un restaurant aux favoris
     */
    public function store(Restaurant $restaurant)
    {
        $user = auth()->user();

        if ($user->hasFavorite($restaurant)) {
            return back()->with('info', 'Ce restaurant est déjà dans vos favoris.');
        }

        $user->favoris()->attach($restaurant->id, [
            'ajouter_favoris' => true,
            'supprimer_favoris' => false,
        ]);

        return back()->with('success', 'Restaurant ajouté aux favoris !');
    }

    /**
     * Retirer un restaurant des favoris
     */
    public function destroy(Restaurant $restaurant)
    {
        $user = auth()->user();

        if (!$user->hasFavorite($restaurant)) {
            return back()->with('error', 'Ce restaurant n\'est pas dans vos favoris.');
        }

        $user->favoris()->detach($restaurant->id);

        return back()->with('success', 'Restaurant retiré des favoris !');
    }
}