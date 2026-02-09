<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Menu;
use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PlatController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Restaurant $restaurant, Menu $menu)
    {
        $this->authorize('update', $restaurant);
        
        return view('plats.create', compact('restaurant', 'menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Restaurant $restaurant, Menu $menu)
    {
        $this->authorize('update', $restaurant);

        $validated = $request->validate([
            'content' => 'required|string|max:255',
            'prix_unit' => 'required|numeric|min:0',
        ]);

        $validated['menu_id'] = $menu->id;

        Plat::create($validated);

        return redirect()
            ->route('menus.show', [$restaurant, $menu])
            ->with('success', 'Plat ajouté avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant, Menu $menu, Plat $plat)
    {
        $this->authorize('update', $restaurant);
        
        return view('plats.edit', compact('restaurant', 'menu', 'plat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant, Menu $menu, Plat $plat)
    {
        $this->authorize('update', $restaurant);

        $validated = $request->validate([
            'content' => 'required|string|max:255',
            'prix_unit' => 'required|numeric|min:0',
        ]);

        $plat->update($validated);

        return redirect()
            ->route('menus.show', [$restaurant, $menu])
            ->with('success', 'Plat modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant, Menu $menu, Plat $plat)
    {
        $this->authorize('update', $restaurant);

        $plat->delete();

        return redirect()
            ->route('menus.show', [$restaurant, $menu])
            ->with('success', 'Plat supprimé avec succès !');
    }
}