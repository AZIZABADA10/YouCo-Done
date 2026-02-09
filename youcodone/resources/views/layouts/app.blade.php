<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'YouCoDone') }} - @yield('title', 'Réservation de restaurants')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('restaurants.index') }}" class="text-2xl font-bold text-indigo-600">
                            YouCo'Done
                        </a>
                    </div>
                    
                    <!-- Navigation Links -->
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('restaurants.index') }}" 
                           class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('restaurants.index') ? 'border-b-2 border-indigo-500 text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                            Restaurants
                        </a>
                        
                        @auth
                            @role('restaurateur|admin')
                                <a href="{{ route('restaurants.my') }}" 
                                   class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('restaurants.my') ? 'border-b-2 border-indigo-500 text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                                    Mes Restaurants
                                </a>
                            @endrole
                            
                            @role('client|restaurateur')
                                <a href="{{ route('favoris.index') }}" 
                                   class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('favoris.index') ? 'border-b-2 border-indigo-500 text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                                    Mes Favoris
                                </a>
                            @endrole
                            
                            @role('admin')
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('admin.*') ? 'border-b-2 border-indigo-500 text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                                    Admin
                                </a>
                            @endrole
                        @endauth
                    </div>
                </div>
                
                <!-- Right Side -->
                <div class="flex items-center">
                    @auth
                        <div class="ml-3 relative">
                            <span class="text-sm text-gray-700 mr-4">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900 mr-4">Connexion</a>
                        <a href="{{ route('register') }}" class="text-sm bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            Inscription
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Messages Flash -->
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Page Content -->
    <main class="py-10">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-20">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} YouCo'Done. Tous droits réservés.
            </p>
        </div>
    </footer>
</body>
</html>