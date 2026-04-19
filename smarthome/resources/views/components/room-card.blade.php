@props(['room'])

<div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all border border-gray-100 overflow-hidden">
    <!-- Card Header -->
    <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-{{ $room->icon ?? 'home' }} text-blue-500"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">{{ $room->name }}</h3>
                    <p class="text-xs text-gray-500">{{ $room->light_on ? 'Lumière allumée' : 'Lumière éteinte' }}</p>
                </div>
            </div>

            <!-- Status Indicator -->
            <div class="flex space-x-1">
                <span class="w-2 h-2 rounded-full {{ $room->light_on ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                <span class="w-2 h-2 rounded-full {{ $room->shutter_open ? 'bg-blue-500' : 'bg-gray-300' }}"></span>
            </div>
        </div>
    </div>

    <!-- Card Body -->
    <div class="p-5 space-y-4">
        <x-light-control :room="$room" />
        <x-shutter-control :room="$room" />
        <x-temperature-control :room="$room" />
    </div>

    <!-- Card Footer -->
    <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex justify-between text-xs text-gray-500">
        <span>Dernière mise à jour: il y a 5 min</span>
        <button class="text-blue-500 hover:text-blue-600">
            <i class="fas fa-cog"></i>
        </button>
    </div>
</div>
