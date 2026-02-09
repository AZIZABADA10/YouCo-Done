@extends('layouts.app')

@section('title', 'Tous les restaurants')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Titre et bouton de création -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Découvrez nos restaurants</h1>
        
        @auth
            @role('restaurateur|admin')
                <a href="{{ route('restaurants.create') }}" 
                   class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">
                    + Ajouter un restaurant
                </a>
            @endrole
        @endauth
    </div>

    <!-- Formulaire de recherche -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('restaurants.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Recherche par nom -->
            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom du restaurant</label>
                <input type="text" 
                       name="nom" 
                       id="nom" 
                       value="{{ request('nom') }}"
                       placeholder="Rechercher..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Recherche par ville -->
            <div>
                <label for="localisation" class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                <input type="text" 
                       name="localisation" 
                       id="localisation" 
                       value="{{ request('localisation') }}"
                       placeholder="Paris, Lyon..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Recherche par cuisine -->
            <div>
                <label for="cuisine_id" class="block text-sm font-medium text-gray-700 mb-2">Type de cuisine</label>
                <select name="cuisine_id" 
                        id="cuisine_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Toutes les cuisines</option>
                    @foreach($cuisines as $cuisine)
                        <option value="{{ $cuisine->id }}" {{ request('cuisine_id') == $cuisine->id ? 'selected' : '' }}>
                            {{ $cuisine->type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Boutons -->
            <div class="flex items-end gap-2">
                <button type="submit" 
                        class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    Rechercher
                </button>
                <a href="{{ route('restaurants.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <!-- Résultats -->
    @if($restaurants->isEmpty())
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg">Aucun restaurant trouvé.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($restaurants as $restaurant)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <!-- Image -->
                    <div class="h-48 bg-gray-200 overflow-hidden">
                        @if($restaurant->photos->isNotEmpty())
                            <img src="{{ Storage::url($restaurant->photos->first()->image) }}" 
                                 alt="{{ $restaurant->nom }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Contenu -->
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $restaurant->nom }}</h3>
                        
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <p class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $restaurant->localisation }}
                            </p>
                            <p class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                {{ $restaurant->cuisine->type }}
                            </p>
                            <p class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Capacité: {{ $restaurant->capacite }} personnes
                            </p>
                        </div>

                        <a href="{{ route('restaurants.show', $restaurant) }}" 
                           class="block w-full text-center bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700">
                            Voir les détails
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $restaurants->links() }}
        </div>
    @endif
</div>
@endsection