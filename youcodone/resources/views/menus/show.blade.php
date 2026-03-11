@extends('layouts.app')

@section('title', $menu->nom . ' - ' . $restaurant->nom)

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="mb-4 flex justify-between items-center">
            <a href="{{ route('menus.index', $restaurant) }}" class="text-indigo-600 hover:text-indigo-900">&larr; Retour à tous les menus</a>
            <a href="{{ route('plats.create', [$restaurant, $menu]) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out">
                + Ajouter un plat
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
            <div class="p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $menu->nom }}</h1>
                @if($menu->description)
                    <p class="text-gray-700">{{ $menu->description }}</p>
                @endif
            </div>
        </div>

        <!-- Section des Plats -->
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Composition du menu</h2>
        
        @if($menu->plats->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    @foreach($menu->plats as $plat)
                        <li>
                            <div class="px-4 py-4 flex items-center justify-between sm:px-6">
                                <div class="flex-1">
                                    <h3 class="text-lg font-medium text-indigo-600 truncate">{{ $plat->content }}</h3>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="font-bold text-gray-900 whitespace-nowrap">
                                        {{ $plat->getFormattedPrice() }}
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('plats.edit', [$restaurant, $menu, $plat]) }}" class="text-sm text-yellow-600 hover:text-yellow-900">Modifier</a>
                                        <form action="{{ route('plats.destroy', [$restaurant, $menu, $plat]) }}" method="POST" onsubmit="return confirm('Retirer ce plat du menu ?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-900">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 text-center text-gray-500">
                    <p class="mb-4">Ce menu ne contient encore aucun plat.</p>
                    <a href="{{ route('plats.create', [$restaurant, $menu]) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Ajouter un premier plat
                    </a>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
