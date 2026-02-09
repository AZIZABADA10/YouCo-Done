@extends('layouts.app')

@section('title', $restaurant->nom)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Bouton retour -->
    <a href="{{ route('restaurants.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mb-6">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Retour à la liste
    </a>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Images -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">
            @forelse($restaurant->photos as $photo)
                <img src="{{ Storage::url($photo->image) }}" 
                     alt="{{ $restaurant->nom }}"
                     class="w-full h-64 object-cover rounded-lg">
            @empty
                <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center col-span-2">
                    <span class="text-gray-400">Aucune photo disponible</span>
                </div>
            @endforelse
        </div>

        <!-- Informations principales -->
        <div class="p-6 border-t">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $restaurant->nom }}</h1>
                    <p class="text-lg text-gray-600">{{ $restaurant->cuisine->type }}</p>
                </div>

                <!-- Boutons d'action -->
                <div class="flex gap-2">
                    @auth
                        @if($isFavorite)
                            <form method="POST" action="{{ route('favoris.destroy', $restaurant) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-100 text-red-600 px-4 py-2 rounded-md hover:bg-red-200">
                                    ❤️ Retirer des favoris
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('favoris.store', $restaurant) }}">
                                @csrf
                                <button type="submit" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-md hover:bg-gray-200">
                                    🤍 Ajouter aux favoris
                                </button>
                            </form>
                        @endif

                        @can('update', $restaurant)
                            <a href="{{ route('restaurants.edit', $restaurant) }}" 
                               class="bg-indigo-100 text-indigo-600 px-4 py-2 rounded-md hover:bg-indigo-200">
                                Modifier
                            </a>
                        @endcan
                    @endauth
                </div>
            </div>

            <!-- Détails -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">📍 Localisation</h3>
                    <p class="text-gray-600">{{ $restaurant->localisation }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">👥 Capacité</h3>
                    <p class="text-gray-600">{{ $restaurant->capacite }} personnes</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">🍽️ Type de cuisine</h3>
                    <p class="text-gray-600">{{ $restaurant->cuisine->type }}</p>
                </div>
            </div>

            <!-- Horaires -->
            @if($restaurant->horaires->isNotEmpty())
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4">🕐 Horaires d'ouverture</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        @foreach($restaurant->horaires as $horaire)
                            <div class="flex justify-between p-2 bg-gray-50 rounded">
                                <span class="font-medium">{{ $horaire->jour_semaine }}</span>
                                <span class="text-gray-600">{{ $horaire->getFormattedHours() }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Menus -->
            @if($restaurant->menus->isNotEmpty())
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">📋 Nos Menus</h3>
                    @foreach($restaurant->menus as $menu)
                        <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-semibold mb-3">Menu {{ $loop->iteration }}</h4>
                            @if($menu->plats->isNotEmpty())
                                <div class="space-y-2">
                                    @foreach($menu->plats as $plat)
                                        <div class="flex justify-between items-center">
                                            <span>{{ $plat->content }}</span>
                                            <span class="font-semibold text-indigo-600">{{ $plat->getFormattedPrice() }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-3 pt-3 border-t flex justify-between font-bold">
                                    <span>Total</span>
                                    <span class="text-indigo-600">{{ number_format($menu->getTotalPrice(), 2) }} €</span>
                                </div>
                            @else
                                <p class="text-gray-500">Aucun plat dans ce menu</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Actions restaurateur -->
            @can('update', $restaurant)
                <div class="mt-6 pt-6 border-t flex gap-2">
                    <a href="{{ route('horaires.edit', $restaurant) }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Gérer les horaires
                    </a>
                    <a href="{{ route('menus.index', $restaurant) }}" 
                       class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                        Gérer les menus
                    </a>
                    @can('delete', $restaurant)
                        <form method="POST" action="{{ route('restaurants.destroy', $restaurant) }}" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce restaurant ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                                Supprimer
                            </button>
                        </form>
                    @endcan
                </div>
            @endcan
        </div>
    </div>
</div>
@endsection