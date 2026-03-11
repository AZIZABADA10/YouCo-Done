@extends('layouts.app')

@section('title', 'Modifier le plat - ' . $menu->nom)

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        
        <div class="mb-4">
            <a href="{{ route('menus.show', [$restaurant, $menu]) }}" class="text-indigo-600 hover:text-indigo-900">&larr; Retour au menu</a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Modifier le Plat</h2>

                <form method="POST" action="{{ route('plats.update', [$restaurant, $menu, $plat]) }}">
                    @csrf
                    @method('PUT')

                    <!-- Contenu / Nom du plat -->
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700">Nom du plat ou Contenu</label>
                        <input type="text" name="content" id="content" value="{{ old('content', $plat->content) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('content')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prix unitaire -->
                    <div class="mb-6">
                        <label for="prix_unit" class="block text-sm font-medium text-gray-700">Prix (en DH)</label>
                        <input type="number" step="0.01" min="0" name="prix_unit" id="prix_unit" value="{{ old('prix_unit', $plat->prix_unit) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('prix_unit')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
