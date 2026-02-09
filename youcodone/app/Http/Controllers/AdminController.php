<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Tableau de bord admin
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_clients' => User::role('client')->count(),
            'total_restaurateurs' => User::role('restaurateur')->count(),
            'total_restaurants' => Restaurant::count(),
            'active_restaurants' => Restaurant::active()->count(),
            'total_cuisines' => \App\Models\Cuisine::count(),
        ];

        $recent_restaurants = Restaurant::with(['user', 'cuisine'])
            ->latest()
            ->take(10)
            ->get();

        $recent_users = User::with('roles')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_restaurants', 'recent_users'));
    }

    /**
     * Gérer les utilisateurs
     */
    public function users()
    {
        $users = User::with('roles')
            ->latest()
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    /**
     * Désactiver un utilisateur
     */
    public function toggleUserStatus(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $status = $user->is_active ? 'activé' : 'désactivé';

        return back()->with('success', "Utilisateur {$status} avec succès !");
    }

    /**
     * Supprimer un utilisateur
     */
    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte !');
        }

        $user->delete();

        return back()->with('success', 'Utilisateur supprimé avec succès !');
    }

    /**
     * Gérer tous les restaurants
     */
    public function restaurants()
    {
        $restaurants = Restaurant::with(['user', 'cuisine'])
            ->latest()
            ->paginate(20);

        return view('admin.restaurants', compact('restaurants'));
    }

    /**
     * Supprimer un restaurant (admin)
     */
    public function deleteRestaurant(Restaurant $restaurant)
    {
        $restaurant->delete();

        return back()->with('success', 'Restaurant supprimé avec succès !');
    }
}