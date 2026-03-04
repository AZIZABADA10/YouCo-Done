@extends('layouts.app')

@section('title', 'Tableau de bord Administrateur')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Tableau de bord Administrateur</h1>
        <p class="mt-2 text-gray-600">Vue d'ensemble de la plateforme YouCo'Done</p>
    </div>

    <!-- Navigation rapide Admin -->
    <div class="mb-8 flex gap-4">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm">Vue d'ensemble</a>
        <a href="{{ route('admin.users') }}" class="px-4 py-2 bg-white text-gray-700 hover:bg-gray-50 border border-gray-300 rounded-md shadow-sm">Gérer les Utilisateurs</a>
        <a href="{{ route('admin.restaurants') }}" class="px-4 py-2 bg-white text-gray-700 hover:bg-gray-50 border border-gray-300 rounded-md shadow-sm">Gérer les Restaurants</a>
    </div>

    <!-- Statistiques Globales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-indigo-500">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-2">Total Utilisateurs</h3>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
            <div class="mt-2 text-sm text-gray-600 flex justify-between">
                <span>{{ $stats['total_clients'] }} Clients</span>
                <span>{{ $stats['total_restaurateurs'] }} Restaurateurs</span>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-2">Total Restaurants</h3>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_restaurants'] }}</p>
            <div class="mt-2 text-sm text-green-600 font-medium">
                {{ $stats['active_restaurants'] }} Actifs
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-2">Types de Cuisine</h3>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_cuisines'] }}</p>
            <div class="mt-2 text-sm text-gray-600">
                Catégories disponibles
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-2">État du système</h3>
            <p class="text-3xl font-bold text-gray-900">En ligne</p>
            <div class="mt-2 text-sm text-purple-600 font-medium flex items-center">
                <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span> Opérationnel
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Récents Restaurants -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-800">Derniers Restaurants</h2>
                <a href="{{ route('admin.restaurants') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Voir tout</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Restaurant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Restaurateur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cuisine</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recent_restaurants as $restaurant)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <a href="{{ route('restaurants.show', $restaurant) }}" class="hover:text-indigo-600">{{ $restaurant->nom }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $restaurant->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ $restaurant->cuisine->type }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Aucun restaurant trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Récents Utilisateurs -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-800">Derniers Inscrits</h2>
                <a href="{{ route('admin.users') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Voir tout</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recent_users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->roles->pluck('name')->implode(', ') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->is_active)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Actif</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactif</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Aucun utilisateur trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
