@extends('layouts.app')

@section('title', 'Gestion des restaurants')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Restaurants</h1>
            <p class="mt-2 text-gray-600">Interface d'administration de tous les restaurants</p>
        </div>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                &larr; Retour au Dashboard
            </a>
        </div>
    </div>

    <!-- Navigation rapide Admin -->
    <div class="mb-8 flex gap-4">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-white text-gray-700 hover:bg-gray-50 border border-gray-300 rounded-md shadow-sm">Vue d'ensemble</a>
        <a href="{{ route('admin.users') }}" class="px-4 py-2 bg-white text-gray-700 hover:bg-gray-50 border border-gray-300 rounded-md shadow-sm">Gérer les Utilisateurs</a>
        <a href="{{ route('admin.restaurants') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm">Gérer les Restaurants</a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Restaurant</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Restaurateur</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Détails</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Créé le</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($restaurants as $restaurant)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                #{{ $restaurant->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 border-b border-transparent hover:border-indigo-600 inline-block transition">
                                            <a href="{{ route('restaurants.show', $restaurant) }}">{{ $restaurant->nom }}</a>
                                        </div>
                                        <div class="text-sm text-gray-500 flex items-center">
                                            <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                            {{ $restaurant->localisation }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $restaurant->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $restaurant->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 mb-1">
                                    {{ $restaurant->cuisine->type }}
                                </span>
                                <div class="text-xs text-gray-500">{{ $restaurant->capacite }} max chars</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $restaurant->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('restaurants.edit', $restaurant) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded inline-block">Modifier</a>
                                
                                <form action="{{ route('admin.restaurants.delete', $restaurant) }}" method="POST" class="inline-block" onsubmit="return confirm('Attention ! Supprimer ce restaurant supprimera également ses menus, plats, et favoris associés. Continuer ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded inline-block">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500 text-lg">
                                Aucun restaurant trouvé dans la base de données.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($restaurants->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $restaurants->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
