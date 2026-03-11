@extends('layouts.app')

@section('title', 'Créer un Menu')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        
        <div class="mb-4">
            <a href="{{ route('menus.index', $restaurant) }}" class="text-indigo-600 hover:text-indigo-900">&larr; Retour aux menus</a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Nouveau Menu pour {{ $restaurant->nom }}</h2>

                <form method="POST" action="{{ route('menus.store', $restaurant) }}">
                    @csrf

                    <!-- Nom -->
                    <div class="mb-4">
                        <label for="nom" class="block text-sm font-medium text-gray-700">Nom du menu (ex: Menu Déjeuner, Menu Enfant...)</label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('nom')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description (Optionnel)</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Créer le menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
