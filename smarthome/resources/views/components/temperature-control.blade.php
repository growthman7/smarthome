@props(['room'])

<div x-data="{
    temperature: {{ $room->temperature }},
    updateTemperature() {
        fetch('{{ route('rooms.temperature.update', $room) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                temperature: this.temperature
            })
        });
    }
}" class="bg-gray-50 rounded-lg p-4">
    <div class="flex items-center justify-between mb-3">
        <span class="text-sm font-medium text-gray-600">Température</span>
        <span class="text-lg font-semibold text-blue-600" x-text="temperature + '°C'"></span>
    </div>

    <input type="range"
           min="16"
           max="30"
           step="0.5"
           x-model="temperature"
           @change="updateTemperature()"
           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-500">

    <div class="flex justify-between text-xs text-gray-500 mt-1">
        <span>16°C</span>
        <span>30°C</span>
    </div>
</div>
