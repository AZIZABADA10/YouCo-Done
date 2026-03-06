@extends('layouts.app')

@section('title', 'Modifier ' . $restaurant->nom)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">Modifier : {{ $restaurant->nom }}</h1>
        <a href="{{ route('restaurants.show', $restaurant) }}" class="text-indigo-600 hover:text-indigo-800">
            &larr; Retour au restaurant
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden p-6 hover:shadow-lg transition">
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Il y a des erreurs dans votre formulaire :</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('restaurants.update', $restaurant) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Informations Générales -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Informations Générales</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom du restaurant <span class="text-red-500">*</span></label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom', $restaurant->nom) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition"
                               placeholder="Ex: Le Petit Chef">
                    </div>

                    <div>
                        <label for="cuisine_id" class="block text-sm font-medium text-gray-700 mb-1">Type de cuisine <span class="text-red-500">*</span></label>
                        <select name="cuisine_id" id="cuisine_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="">Sélectionnez un type</option>
                            @foreach($cuisines as $cuisine)
                                <option value="{{ $cuisine->id }}" {{ old('cuisine_id', $restaurant->cuisine_id) == $cuisine->id ? 'selected' : '' }}>
                                    {{ $cuisine->type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-gray-400 font-normal">(Optionnelle)</span></label>
                        <textarea name="description" id="description" rows="4" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition"
                                  placeholder="Décrivez votre restaurant, l'ambiance, vos spécialités...">{{ old('description', $restaurant->description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Détails Pratiques -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Détails Pratiques</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="localisation" class="block text-sm font-medium text-gray-700 mb-1">Adresse complète / Ville <span class="text-red-500">*</span></label>
                        <input type="text" name="localisation" id="localisation" value="{{ old('localisation', $restaurant->localisation) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition"
                               placeholder="123 Rue de la Paix, 75000 Paris">
                    </div>

                    <div>
                        <label for="capacite" class="block text-sm font-medium text-gray-700 mb-1">Capacité maximale (couverts) <span class="text-red-500">*</span></label>
                        <input type="number" name="capacite" id="capacite" value="{{ old('capacite', $restaurant->capacite) }}" required min="1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition"
                               placeholder="Ex: 50">
                    </div>

                    <div>
                        <label for="ouverture_a" class="block text-sm font-medium text-gray-700 mb-1">Date d'ouverture <span class="text-gray-400 font-normal">(Optionnelle)</span></label>
                        <input type="date" name="ouverture_a" id="ouverture_a" value="{{ old('ouverture_a', $restaurant->ouverture_a ? $restaurant->ouverture_a->format('Y-m-d') : '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition">
                    </div>
                </div>
            </div>

            <!-- Médias (Gérer les photos) -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Gérer les Photos</h2>
                
                @if($restaurant->photos->isNotEmpty())
                    <div class="mb-6">
                        <p class="text-sm font-medium text-gray-700 mb-2">Photos actuelles (Cochez pour supprimer)</p>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach($restaurant->photos as $photo)
                                <div class="relative group rounded-lg overflow-hidden border-2 border-transparent hover:border-red-500 transition">
                                    <img src="{{ Storage::url($photo->image) }}" class="h-32 w-full object-cover" alt="Photo">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition flex items-start justify-end p-2">
                                        <div class="bg-white rounded-full p-1 shadow">
                                            <input type="checkbox" name="delete_photos[]" value="{{ $photo->id }}" class="h-5 w-5 text-red-600 rounded cursor-pointer" title="Cocher pour supprimer">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ajouter de nouvelles photos (JPEG, PNG) <span class="text-gray-400 font-normal">(Optionnel)</span></label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md bg-white hover:bg-gray-50 transition cursor-pointer" onclick="document.getElementById('photos').click()">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <span class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Cliquez pour uploader</span>
                                    <input id="photos" name="photos[]" type="file" multiple accept="image/jpeg,image/png,image/jpg" class="sr-only">
                                </span>
                                <p class="pl-1">ou glissez-déposez</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG jusqu'à 2MB chacune</p>
                        </div>
                    </div>
                    <!-- Zone de prévisualisation des fichiers sélectionnés -->
                    <div id="file-list" class="mt-3 text-sm text-gray-600 hidden">
                        <p class="font-medium text-indigo-600">Nouveaux fichiers sélectionnés :</p>
                        <ul id="file-names" class="list-disc pl-5 mt-1 space-y-1 text-gray-500"></ul>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-4 pt-4 border-t">
                <a href="{{ route('restaurants.show', $restaurant) }}" class="px-6 py-2.5 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition font-medium">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2.5 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition font-medium">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Script simple pour afficher les noms des fichiers sélectionnés
    document.getElementById('photos').addEventListener('change', function(e) {
        const fileList = document.getElementById('file-list');
        const fileNames = document.getElementById('file-names');
        
        fileNames.innerHTML = ''; // Clear existing
        
        if (this.files.length > 0) {
            fileList.classList.remove('hidden');
            for (let i = 0; i < this.files.length; i++) {
                const li = document.createElement('li');
                li.textContent = this.files[i].name;
                fileNames.appendChild(li);
            }
        } else {
            fileList.classList.add('hidden');
        }
    });
</script>
@endsection
