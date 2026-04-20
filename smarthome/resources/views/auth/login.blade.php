@extends('layouts.auth')
@section('content')
{{-- Créer une page de login avec tailwindcss --}}
<div class="flex items-center justify-center h-screen">
    <div class="bg-gray-800/50 backdrop-blur-lg border border-gray-700 rounded-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Se connecter à SmartHome</h2>
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
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
                <div class="flex items-center w-full bg-gray-700 border border-gray-600 placeholder:text-gray-500 text-white focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm">
                    <input type="password" name="mdp" id="password" class="w-full p-2 bg-gray-700 border border-gray-600 placeholder:text-gray-500 text-white focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm" placeholder="••••••••" required>
                    <button type="button" class="togglepassword">
                        <i class="bi bi-eye px-2"></i>
                    </button>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember_me" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-300">
                        Se souvenir de moi
                    </label>
                </div>
                <div class="text-sm">
                    <a href="#" class="font-medium text-blue-500 hover:text-blue-400">
                        Mot de passe oublié?
                    </a>
                </div>
            </div>
            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Se connecter
                </button>
            </div>
            <div>
                <p class="text-center text-sm text-gray-300">
                    Pas de compte?
                    <a href="{{ route('register.index') }}" class="font-medium text-blue-500 hover:text-blue-400">
                        S'inscrire
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        document.querySelector('.togglepassword').addEventListener('click', () => {
            const pwdInput = this.previousElementSibling;
            pwdInput.type = (pwdInput.type === "password") ? "text" : "password";
        });
    </script>
@endpush
