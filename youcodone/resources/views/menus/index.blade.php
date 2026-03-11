@extends('layouts.app')

@section('title', 'Gestion des menus - ' . $restaurant->nom)

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="mb-4">
            <a href="{{ route('restaurants.my') }}" class="text-indigo-600 hover:text-indigo-900">&larr; Retour à mes restaurants</a>
        </div>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Menus de {{ $restaurant->nom }}</h1>
            <a href="{{ route('menus.create', $restaurant) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out">
                + Ajouter un menu
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if($menus->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($menus as $menu)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                        <div class="p-6 flex-grow">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $menu->nom }}</h3>
                            @if($menu->description)
                                <p class="text-gray-600 mb-4 text-sm">{{ Str::limit($menu->description, 100) }}</p>
                            @endif
                            <div class="text-sm text-gray-500 mb-4">
                                {{ $menu->plats->count() }} plat(s) enregistré(s)
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 flex justify-between border-t border-gray-100">
                            <a href="{{ route('menus.show', [$restaurant, $menu]) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">Voir en détail</a>
                            <div class="flex space-x-3">
                                <a href="{{ route('menus.edit', [$restaurant, $menu]) }}" class="text-yellow-600 hover:text-yellow-900 text-sm">Modifier</a>
                                <form action="{{ route('menus.destroy', [$restaurant, $menu]) }}" method="POST" onsubmit="return confirm('Supprimer ce menu et tous ses plats ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun menu</h3>
                    <p class="mt-1 text-sm text-gray-500">Vous n'avez pas encore créé de menu pour ce restaurant.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
