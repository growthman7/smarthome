@extends('layouts.app')
@section('content')
    <div class="container mx-auto py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold">Détails de la Pièce</h1>
            {{-- ajouter un bouton  pour modal d'ajout d'un appareil dans la pièce --}}
            <button data-modal-target="addDeviceModal" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                <i class="bi bi-plus-circle"></i> Ajouter un appareil
            </button>
        </div>
        <!-- Content for the room details page -->
        <div class="bg-gray-800/50 backdrop-blur-lg border border-gray-700 rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">{{ $piece->nom }}</h2>
            <p class="text-gray-300">Détails de la pièce et ses appareils connectés.</p>
            <!-- Example content for devices in the room -->
            <div class="mt-4">
                @foreach($piece->devices as $device)
                    <div class="bg-gray-700/50 backdrop-blur-lg border border-gray-600 rounded-lg p-4 mb-4">
                        <h3 class="text-lg font-semibold">{{ $device->nom }}</h3>
                        <p class="text-gray-300">Type: {{ $device->type }}</p>
                        <!-- Additional device details can go here -->
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{-- Modal for adding a new device (hidden by default) --}}
    <div id="addDeviceModal" class="fixed inset-0 flex items-center justify-center dark:bg-black dark:bg-opacity-50 backdrop-blur-lg hidden" data-type="modal">
        <div class="block bg-gray-800/50 backdrop-blur-lg border border-gray-700 rounded-lg p-6 w-full max-w-md min-h-[200px]">
            <h2 class="text-xl font-semibold mb-4">Ajouter un nouvel appareil</h2>
            <form action="{{ route('devices.store') }}" method="POST">
                @csrf
                <input type="hidden" name="piece_id" value="{{ $piece->id }}">
                <div class="mb-4">
                    <label for="nom" class="block text-gray-300 mb-2">Nom de l'appareil</label>
                    <input type="text" name="nom" id="nom" class="w-full px-3 py-2 bg-gray-700/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="type" class="block text-gray-300 mb-2">Type d'appareil</label>
                    <select name="type" id="type" class="w-full px-3 py-2 bg-gray-700/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="light">Lumière</option>
                        <option value="shutter">Volet</option>
                        <option value="sensor">Capteur</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="document.getElementById('addDeviceModal').classList.add('hidden')" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded transition mr-2">
                        Annuler
                    </button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded transition">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    // Script to toggle any modal with the data-type="modal" attribute and data-modal-target and close the modal when clicking outside of it but not when clicking inside the modal content
    document.addEventListener('DOMContentLoaded', function () {
        const modalTriggers = document.querySelectorAll('[data-modal-target]');
        modalTriggers.forEach(trigger => {
            trigger.addEventListener('click', function () {
                const targetModalId = this.getAttribute('data-modal-target');
                const targetModal = document.getElementById(targetModalId);
                if (targetModal) {
                    targetModal.classList.remove('hidden');
                }
            });
        });

        // Close modal when clicking outside of it
        const modals = document.querySelectorAll('[data-type="modal"]');
        modals.forEach(modal => {
            modal.addEventListener('click', function (event) {
                if (event.target === this) {
                    this.classList.add('hidden');
                }
            });
        });
    });
</script>
@endpush
