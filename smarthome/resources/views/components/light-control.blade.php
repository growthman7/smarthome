@props(['room'])

<div class="bg-gray-50 rounded-lg p-4">
    <div class="flex items-center justify-between mb-3">
        <span class="text-sm font-medium text-gray-600">Lumière</span>

        <!-- Toggle Switch -->
        <button
                class="relative inline-flex items-center h-6 rounded-full w-11 transition-colors focus:outline-none"
                :class="lightOn ? 'bg-blue-500' : 'bg-gray-300'">
            <span class="inline-block w-4 h-4 transform transition-transform bg-white rounded-full shadow"
                  :class="lightOn ? 'translate-x-6' : 'translate-x-1'"></span>
        </button>
    </div>

    <!-- Brightness Slider -->
    <div x-show="lightOn" x-transition class="mt-3">
        <div class="flex items-center space-x-2">
            <i class="fas fa-sun text-xs text-yellow-500"></i>
            <input type="range"
                   min="0"
                   max="100"
                   x-model="brightness"
                   class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-500">
            <span class="text-xs text-gray-600" x-text="brightness + '%'"></span>
        </div>
    </div>
</div>
