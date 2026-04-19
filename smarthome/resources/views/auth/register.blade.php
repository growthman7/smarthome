@extends('layouts.auth')
@section('content')
    {{-- Créer une page d'inscription avec tailwindcss --}}
    <div class="flex items-center justify-center h-screen">
        <div class="bg-gray-800/50 backdrop-blur-lg border border-gray-700 rounded-lg p-8 w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">S'inscrire à SmartHome</h2>
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300">
                        Nom
                    </label>
                    <input type="text" name="nom" id="name" class="w-full p-2 bg-gray-700 border border-gray-600 placeholder:text-gray-500 text-white focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm" placeholder="Votre nom" required>
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300">
                        Prénom
                    </label>
                    <input type="text" name="prenom" id="name" class="w-full p-2 bg-gray-700 border border-gray-600 placeholder:text-gray-500 text-white focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm" placeholder="Votre prénom" required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">
                        Adresse e-mail
                    </label>
                    <input type="email" name="email" id="email" class="w-full p-2 bg-gray-700 border border-gray-600 placeholder:text-gray-500 text-white focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm" placeholder="votre@email.com" required>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300">
                        Mot de passe
                    </label>
                    <input type="password" name="mdp" id="password" class="w-full p-2 bg-gray-700 border border-gray-600 placeholder:text-gray-500 text-white focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm" placeholder="votre mot de passe" required>
                </div>
                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        S'inscrire
                    </button>
                </div>
                <div>
                    <p class="text-center text-sm text-gray-300">
                        Vous avez un compte ?
                        <a href="{{ route('login.index') }}" class="font-medium text-blue-500 hover:text-blue-400">
                            Se connecter
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
