@extends('layouts.app')

@section('title', 'Gestion des Horaires - ' . $restaurant->nom)

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        
        <div class="mb-4">
            <a href="{{ route('restaurants.my') }}" class="text-indigo-600 hover:text-indigo-900">&larr; Retour à mes restaurants</a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Horaires d'ouverture - {{ $restaurant->nom }}</h2>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('horaires.update', $restaurant) }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        @foreach($jours as $index => $jour)
                            @php
                                $horaire = $horaires->firstWhere('jour_semaine', $jour);
                                $statut = old("horaires.$index.statut", $horaire->statut ?? 'ferme');
                                $ouverture = old("horaires.$index.heure_ouverture", $horaire?->heure_ouverture?->format('H:i') ?? '');
                                $fermeture = old("horaires.$index.heure_fermeture", $horaire?->heure_fermeture?->format('H:i') ?? '');
                            @endphp

                            <div class="flex items-center space-x-4 p-4 border rounded-md {{ $statut === 'ouvert' ? 'bg-indigo-50 border-indigo-200' : 'bg-gray-50 border-gray-200' }}" id="row-{{ $index }}">
                                <input type="hidden" name="horaires[{{ $index }}][jour_semaine]" value="{{ $jour }}">
                                
                                <div class="w-1/4">
                                    <span class="font-semibold text-gray-700">{{ $jour }}</span>
                                </div>

                                <div class="w-1/4">
                                    <select name="horaires[{{ $index }}][statut]" class="statut-select mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" data-index="{{ $index }}">
                                        <option value="ouvert" {{ $statut === 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                                        <option value="ferme" {{ $statut === 'ferme' ? 'selected' : '' }}>Fermé</option>
                                    </select>
                                </div>

                                <div class="w-1/2 flex space-x-2 heure-inputs-{{ $index }}" style="{{ $statut === 'ferme' ? 'display: none;' : '' }}">
                                    <div class="w-1/2">
                                        <label class="sr-only">Heure d'ouverture</label>
                                        <input type="time" name="horaires[{{ $index }}][heure_ouverture]" value="{{ $ouverture }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <span class="flex items-center text-gray-500">à</span>
                                    <div class="w-1/2">
                                        <label class="sr-only">Heure de fermeture</label>
                                        <input type="time" name="horaires[{{ $index }}][heure_fermeture]" value="{{ $fermeture }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">
                            Enregistrer les horaires
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selects = document.querySelectorAll('.statut-select');
        
        selects.forEach(select => {
            select.addEventListener('change', function() {
                const index = this.getAttribute('data-index');
                const inputsDiv = document.querySelector(`.heure-inputs-${index}`);
                const rowDiv = document.getElementById(`row-${index}`);
                
                if (this.value === 'ouvert') {
                    inputsDiv.style.display = 'flex';
                    rowDiv.classList.add('bg-indigo-50', 'border-indigo-200');
                    rowDiv.classList.remove('bg-gray-50', 'border-gray-200');
                } else {
                    inputsDiv.style.display = 'none';
                    rowDiv.classList.add('bg-gray-50', 'border-gray-200');
                    rowDiv.classList.remove('bg-indigo-50', 'border-indigo-200');
                    
                    // Optionnel : vider les champs si on ferme ?
                    // inputsDiv.querySelectorAll('input[type="time"]').forEach(i => i.value = '');
                }
            });
        });
    });
</script>
@endsection
