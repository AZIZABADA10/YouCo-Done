@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 border-b pb-4">
        <h1 class="text-3xl font-bold text-gray-900">Paramètres du profil</h1>
        <p class="mt-2 text-gray-600">Gérez vos informations personnelles et la sécurité de votre compte.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-12">
        
        <!-- Colonne de gauche (Navigation optionnelle ou info) -->
        <div class="hidden lg:block lg:col-span-1">
            <nav class="space-y-1">
                <a href="#profile-info" class="bg-indigo-50 text-indigo-700 hover:text-indigo-700 hover:bg-white group rounded-md px-3 py-2 flex items-center text-sm font-medium">
                    <svg class="text-indigo-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="truncate">Informations du compte</span>
                </a>
            </nav>
        </div>

        <!-- Contenu principal -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Informations -->
            <div id="profile-info" class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Informations Personnelles</h3>
                    <div class="mt-5 text-sm text-gray-500">
                        Mettez à jour les informations de votre profil et votre adresse email.
                    </div>
                    
                    <div class="mt-6 max-w-xl text-sm text-gray-500">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <!-- Mot de passe -->
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Mettre à jour le mot de passe</h3>
                    <div class="mt-5 text-sm text-gray-500">
                        Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.
                    </div>
                    
                    <div class="mt-6 max-w-xl text-sm text-gray-500">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-white shadow sm:rounded-lg border border-red-100">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-red-700">Zone de danger</h3>
                    <div class="mt-5 text-sm text-gray-500">
                        Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.
                    </div>
                    
                    <div class="mt-6 max-w-xl text-sm text-gray-500">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
