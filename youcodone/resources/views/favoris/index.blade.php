@extends('layouts.app')

@section('title', 'Mes Favoris')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Mes Restaurants Favoris</h1>
        <a href="{{ route('restaurants.index') }}" class="text-indigo-600 hover:text-indigo-900">
            Explorer plus de restaurants &rarr;
        </a>
    </div>

    @if($favoris->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
            <h2 class="text-2xl font-medium text-gray-900 mb-2">Vous n'avez pas encore de favoris</h2>
            <p class="text-gray-500 mb-6">Ajoutez des restaurants à vos favoris en cliquant sur l'icône cœur sur leur page.</p>
            <a href="{{ route('restaurants.index') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700 font-medium transition">
                Découvrir des restaurants
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($favoris as $restaurant)
                <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col hover:shadow-xl transition">
                    <!-- Image -->
                    <div class="h-48 bg-gray-200 relative overflow-hidden group">
                        @if($restaurant->photos->isNotEmpty())
                            <img src="{{ Storage::url($restaurant->photos->first()->image) }}" 
                                 alt="{{ $restaurant->nom }}"
                                 class="w-full h-full object-cover transition duration-300 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Bouton retirer favori absolu -->
                        <form action="{{ route('favoris.destroy', $restaurant) }}" method="POST" class="absolute top-2 right-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-white bg-opacity-90 rounded-full hover:bg-red-50 text-red-500 hover:text-red-600 transition shadow-sm" title="Retirer des favoris">
                                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- Contenu -->
                    <div class="p-4 flex-grow flex flex-col">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-semibold text-gray-900 line-clamp-1">{{ $restaurant->nom }}</h3>
                            <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full whitespace-nowrap">{{ $restaurant->cuisine->type }}</span>
                        </div>
                        
                        <div class="space-y-1 text-sm text-gray-600 mb-4 flex-grow">
                            <p class="flex items-center text-gray-500">
                                <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="line-clamp-1">{{ $restaurant->localisation }}</span>
                            </p>
                        </div>

                        <a href="{{ route('restaurants.show', $restaurant) }}" 
                           class="mt-auto block w-full text-center bg-indigo-50 text-indigo-700 py-2 rounded-md hover:bg-indigo-100 transition font-medium">
                            Voir le restaurant
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $favoris->links() }}
        </div>
    @endif
</div>
@endsection
