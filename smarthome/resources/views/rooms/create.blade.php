@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-white">Ajouter une nouvelle pièce</h2>
        <p class="text-gray-600 mt-1">Configurez une nouvelle pièce dans votre maison connectée</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('rooms.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Room Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nom de la pièce <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="nom" placeholder="ex: Salon, Chambre, Cuisine..." class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all text-black" required>
            </div>

            <!-- Icon Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Choix de la maison <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-3 sm:grid-cols-6 gap-3 text-black">
                    @foreach(auth()->user()->maisons as $maison)
                        <label class="relative">
                            <input type="radio" name="maison_id" value="{{ $maison->id }}" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all" required>
                            <div class="w-full aspect-square bg-gray-50 border-2 border-gray-200 rounded-lg flex items-center justify-center cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-gray-100 transition-all">
                                {{ $maison->nom }} - {{ $maison->adresse }}
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100">
                <a href="{{ route('dashboard') }}" class="px-6 py-2 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors flex items-center space-x-2">
                    <i class="fas fa-save"></i>
                    <span>Ajouter la pièce</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Tips -->
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
