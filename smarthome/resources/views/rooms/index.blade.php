@extends('layouts.app')
@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">Gestion des Pièces</h1>
        <!-- Content for the rooms index page -->
        <div class="bg-gray-800/50 backdrop-blur-lg border border-gray-700 rounded-lg p-6 mb-6">
            <p class="text-gray-300">Ici, vous pouvez voir toutes les pièces de votre maison connectée, ajouter de nouvelles pièces, et gérer les pièces existantes.</p>
            <a href="{{ route('rooms.create') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                Ajouter une nouvelle pièce
            </a>
        </div>
        <div class="">
            <div class="flex items-center justify-between">
                <p class="underline">Toutes les pièces</p>
                <p class="underline drop-shadow-[0_0_10px_rgba(255,255,255)]">Scroll -></p>
            </div>
            <div class="flex flex-1 overflow-x-auto mt-2 gap-6">
                @if(auth()->check())
                    @forelse($pieces as $room)
                        <!-- Example Room Card -->
                        <div class="bg-gray-800/50 backdrop-blur-lg border border-gray-700 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-semibold">Salon</h2>
                                <p class="text-gray-300"><i class="bi bi-house-door"></i> {{ $room->maison->nom }}</p>
                            </div>
                            <p class="text-gray-300">Pièce principale pour se détendre et recevoir des invités.</p>
                            <div class="mt-4 flex space-x-2">
                                <a href="{{ route('rooms.show', $room->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                                    Voir les appareils
                                </a>
                            </div>
                        </div>
                        {{-- <div class="bg-gray-800/50 backdrop-blur-lg border border-gray-700 rounded-lg p-4">
                            <h2 class="text-xl font-semibold mb-4">Salon</h2>
                            <p class="text-gray-300">Pièce principale pour se détendre et recevoir des invités.</p>
                            <div class="mt-4 flex space-x-2">
                                <div class="flex gap-2 bg-red-600 hover:bg-green-700 text-white font-semibold py-1 px-3 rounded transition">
                                    <i class="bi bi-lightbulb-fill"></i>
                                    <P>OFF</P>
                                </div>
                                <div class="flex gap-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-1 px-3 rounded transition">
                                    <i class="bi bi-thermometer"></i>
                                    <P>30°</P>
                                </div>
                                <div class="flex gap-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-1 px-3 rounded transition">
                                    <i class="bi bi-window"></i>
                                    <P>DOWN</P>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-800/50 backdrop-blur-lg border border-gray-700 rounded-lg p-4">
                            <h2 class="text-xl font-semibold mb-4">Salon</h2>
                            <p class="text-gray-300">Pièce principale pour se détendre et recevoir des invités.</p>
                            <div class="mt-4 flex space-x-2">
                                <div class="flex gap-2 bg-red-600 hover:bg-green-700 text-white font-semibold py-1 px-3 rounded transition">
                                    <i class="bi bi-lightbulb-fill"></i>
                                    <P>OFF</P>
                                </div>
                                <div class="flex gap-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-1 px-3 rounded transition">
                                    <i class="bi bi-thermometer"></i>
                                    <P>30°</P>
                                </div>
                                <div class="flex gap-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-1 px-3 rounded transition">
                                    <i class="bi bi-window"></i>
                                    <P>DOWN</P>
                                </div>
                            </div>
                        </div>
                        <!-- Repeat similar cards for other rooms --> --}}
                    @empty
                        <p class="text-gray-300 mt-4">Aucune pièce trouvée.
                    @endforelse
                @endif
            </div>
        </div>

    </div>
@endsection
