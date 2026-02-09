<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Cuisine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RestaurantController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Restaurant::with(['cuisine', 'photos', 'user'])
            ->active();

        // Filtres de recherche
        if ($request->filled('localisation')) {
            $query->byLocalisation($request->localisation);
        }

        if ($request->filled('cuisine_id')) {
            $query->byCuisine($request->cuisine_id);
        }

        if ($request->filled('nom')) {
            $query->byNom($request->nom);
        }

        $restaurants = $query->latest()->paginate(12);
        $cuisines = Cuisine::all();

        return view('restaurants.index', compact('restaurants', 'cuisines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Restaurant::class);
        
        $cuisines = Cuisine::all();
        return view('restaurants.create', compact('cuisines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Restaurant::class);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'localisation' => 'required|string|max:255',
            'cuisine_id' => 'required|exists:cuisines,id',
            'capacite' => 'required|integer|min:1',
            'ouverture_a' => 'nullable|date',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['user_id'] = auth()->id();

        $restaurant = Restaurant::create($validated);

        // Gérer l'upload des photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('restaurants', 'public');
                Photo::create([
                    'restaurant_id' => $restaurant->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()
            ->route('restaurants.show', $restaurant)
            ->with('success', 'Restaurant créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant)
    {
        $restaurant->load(['cuisine', 'photos', 'menus.plats', 'horaires', 'user']);
        
        $isFavorite = auth()->check() && auth()->user()->hasFavorite($restaurant);
        
        return view('restaurants.show', compact('restaurant', 'isFavorite'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);
        
        $cuisines = Cuisine::all();
        return view('restaurants.edit', compact('restaurant', 'cuisines'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'localisation' => 'required|string|max:255',
            'cuisine_id' => 'required|exists:cuisines,id',
            'capacite' => 'required|integer|min:1',
            'ouverture_a' => 'nullable|date',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_photos' => 'nullable|array',
            'delete_photos.*' => 'exists:photos,id',
        ]);

        $restaurant->update($validated);

        // Supprimer les photos sélectionnées
        if ($request->filled('delete_photos')) {
            Photo::whereIn('id', $request->delete_photos)
                ->where('restaurant_id', $restaurant->id)
                ->each(fn($photo) => $photo->delete());
        }

        // Ajouter de nouvelles photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('restaurants', 'public');
                Photo::create([
                    'restaurant_id' => $restaurant->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()
            ->route('restaurants.show', $restaurant)
            ->with('success', 'Restaurant modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        $this->authorize('delete', $restaurant);

        $restaurant->delete();

        return redirect()
            ->route('restaurants.index')
            ->with('success', 'Restaurant supprimé avec succès !');
    }

    /**
     * Mes restaurants (restaurateur)
     */
    public function myRestaurants()
    {
        $this->authorize('viewAny', Restaurant::class);
        
        $restaurants = auth()->user()->restaurants()
            ->with(['cuisine', 'photos'])
            ->latest()
            ->paginate(10);

        return view('restaurants.my-restaurants', compact('restaurants'));
    }
}