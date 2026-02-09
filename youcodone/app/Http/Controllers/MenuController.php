<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MenuController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);
        
        $menus = $restaurant->menus()->with('plats')->get();
        
        return view('menus.index', compact('restaurant', 'menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);
        
        return view('menus.create', compact('restaurant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);

        $validated = $request->validate([
            'creer_menu' => 'boolean',
            'supprimer_menu' => 'boolean',
            'modifier_menu' => 'boolean',
            'get_all_menu' => 'boolean',
            'get_by_id' => 'boolean',
        ]);

        $validated['restaurant_id'] = $restaurant->id;

        $menu = Menu::create($validated);

        return redirect()
            ->route('menus.show', [$restaurant, $menu])
            ->with('success', 'Menu créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant, Menu $menu)
    {
        $this->authorize('view', $restaurant);
        
        $menu->load('plats');
        
        return view('menus.show', compact('restaurant', 'menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant, Menu $menu)
    {
        $this->authorize('update', $restaurant);
        
        return view('menus.edit', compact('restaurant', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant, Menu $menu)
    {
        $this->authorize('update', $restaurant);

        $validated = $request->validate([
            'creer_menu' => 'boolean',
            'supprimer_menu' => 'boolean',
            'modifier_menu' => 'boolean',
            'get_all_menu' => 'boolean',
            'get_by_id' => 'boolean',
        ]);

        $menu->update($validated);

        return redirect()
            ->route('menus.show', [$restaurant, $menu])
            ->with('success', 'Menu modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant, Menu $menu)
    {
        $this->authorize('update', $restaurant);

        $menu->delete();

        return redirect()
            ->route('menus.index', $restaurant)
            ->with('success', 'Menu supprimé avec succès !');
    }
}