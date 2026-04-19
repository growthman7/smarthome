@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    {{--  Header  --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-white">Ajouter une nouvelle maison</h2>
        <p class="text-gray-600 mt-1">Configurez une nouvelle maison dans votre système connecté</p>
    </div>

    {{--  Form  --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('homes.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            {{--  Home Name  --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nom de la maison <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="nom" placeholder="ex: Maison principale, Appartement..." class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all text-black" required>
            </div>

             {{--  Home Address  --}}
             <div>
                <label for="adresse" class="block text-sm font-medium text-gray-700 mb-2">
                    Adresse de la maison <span class="text-red-500">*</span>
                </label>
                <input type="text" id="adresse" name="adresse" placeholder="ex: 123 Rue Principale, Paris..." class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all text-black" required>
            </div>

            {{-- Home city --}}
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                    Ville de la maison <span class="text-red-500">*</span>
                </label>
                <input type="text" id="city" name="ville" placeholder="ex: Paris, Lyon, Marseille..." class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all text-black" required>
            </div>

            {{-- Home country --}}
            <div>
                <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                    Pays de la maison <span class="text-red-500">*</span>
                </label>
                <input type="text" id="country" name="pays" placeholder="ex: France, Espagne, Italie..." class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all text-black" required>
            </div>

            {{--  Form Actions  --}}
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100">
                <a href="{{ route('dashboard') }}" class="px-6 py-2 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors flex items-center space-x-2">
                    <i class="fas fa-save"></i>
                    <span>Ajouter la maison</span>
                </button>
            </div>
        </form>
    </div>

    {{--  Tips  --}}
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start space-x-3">
            <i class="fas fa-lightbulb text-blue-500 mt-1"></i>
            <div>
                <h4 class="text-sm font-medium text-blue-800">Astuce</h4>
                <p class="text-sm text-blue-600">Vous pourrez modifier tous ces paramètres plus tard depuis le tableau de bord.</p>
            </div>
        </div>
    </div>
</div>
@endsection
