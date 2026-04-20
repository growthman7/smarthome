@extends('layouts.app')
@section('content')
    {{-- <div>
        <h1 class="text-3xl font-bold mb-6">Bienvenue sur votre tableau de bord SmartHome</h1>
        <p class="text-gray-300 mb-4">Surveillez et contrôlez vos appareils connectés en un seul endroit.</p>
    </div> --}}
    @if(session('success'))
        <div class="alert bg-green-500 text-white p-2">
            {{ session('message') }}
        </div>
    @endif
    <div>
        <div>
            <h1 class="text-2xl font-bold mb-6">Bienvenue sur votre tableau de bord SmartHome</h1>
            <p class="text-gray-300 mb-4">Surveillez et contrôlez vos appareils connectés en un seul endroit.</p>
        </div>
        {{-- cartes de statistiques sur les maisons, pièces, appareils, etc... --}}
        <div>
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-white from-[#0f172a] to-[#020617] p-4 rounded-2xl border border-white/20 shadow-xl">
                    <p class="text-black text-sm">Nombre de maisons</p>
                    <div class="text-2xl font-bold text-blue-500">{{ $count_homes }}</div>
                </div>
                <div class="bg-white from-[#0f172a] to-[#020617] p-4 rounded-2xl border border-white/20 shadow-xl">
                    <p class="text-black text-sm">Nombre de pièces</p>
                    <div class="text-2xl font-bold text-blue-500">{{ $count_rooms }}</div>
                </div>
                <div class="bg-white from-[#0f172a] to-[#020617] p-4 rounded-2xl border border-white/20 shadow-xl">
                    <p class="text-black text-sm">Nombre d'appareils</p>
                    <div class="text-2xl font-bold text-blue-500">{{ $count_devices }}</div>
                </div>
                <div class="bg-white from-[#0f172a] to-[#020617] p-4 rounded-2xl border border-white/20 shadow-xl">
                    <p class="text-black text-sm">Date</p>
                    <div class="text-lg font-bold text-blue-500">{{ date('d-m-Y'); }}</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-2 py-3 ">
            <div class="flex justify-between items-center  mb-4 ">
                <h2 class="italic underline text-xl font-bold">Mes Maisons</h2>
                <a href="{{ route('homes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                    <i class="bi bi-plus-circle-fill"></i> Ajouter maison
                </a>
            </div>
            {{-- cartes de présentation des différentes maisons avec leurs informations --}}
            @forelse($homes as $home)
            <div class="card relative z-10 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-6 mb-4 flex justify-between items-center gap-6 shadow-2xl hover:scale-[1.02] transition duration-300">
                    <div>
                        <p class="text-gray-300 text-xl"><i class="bi bi-house"></i>Maison {{ $home->nom }}</p>
                        <div class="data text-2xl font-bold">{{ $home->adresse }} - {{ $home->ville }}</div>
                    </div>
                    <div>

                        <a href="{{ route('homes.show', $home->id) }}" class="bg-blue-500 rounded-lg p-2 hidden">
                            <i class="bi bi-eye text-white-500 text-2xl"></i>
                        </a>
                    </div>
                </div>
            @empty
                {{-- <p class="text-gray-300">Vous n'avez pas encore de maison enregistrée. Cliquez sur "Ajouter une maison" pour commencer à configurer votre maison connectée.</p> --}}
                <a href="{{ route('homes.create') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                    <i class="bi bi-plus-circle-fill"></i> Ajouter une maison
                </a>
            @endforelse
        </div>
        {{-- card temperature like meteo card --}}
        {{-- <div class="relative bg-gradient-to-br from-[#0f172a] to-[#020617] p-4 mb-4 rounded-2xl overflow-hidden">
            <!-- GLOW BACKGROUND -->
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-orange-500 opacity-30 blur-3xl rounded-full"></div>
            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-pink-500 opacity-30 blur-3xl rounded-full"></div>
            <!-- CARD TEMP -->
            <div class="relative z-10 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-6 mb-4 flex justify-between items-center gap-6 shadow-2xl hover:scale-[1.02] transition duration-300">
                <div>
                    <p class="text-gray-300 text-sm">Température de la maison</p>
                    <div class="text-4xl font-bold text-white">22°C</div>
                </div>
                <div>
                    <img src="https://cdn-icons-png.flaticon.com/512/1116/1116453.png"
                        alt="Temperature Icon"
                        class="w-16 h-16 drop-shadow-[0_0_10px_rgba(255,255,255,0.5)]">
                </div>
            </div>
            <!-- GRID -->
            <div class="relative z-10 grid grid-cols-3 gap-4">
                <!-- CARD 1 -->
                <div class="bg-white/10 backdrop-blur-xl
                            border border-white/20
                            rounded-xl p-4
                            flex items-center justify-between gap-2
                            shadow-xl
                            hover:scale-105 transition">
                            <i class="bi bi-clock-fill text-white font-bold drop-shadow-[0_0_10px_rgba(255,255,255,0.5)] text-xl"></i>
                            <div class="text-lg font-bold text-white">9h00</div>
                </div>
                <!-- CARD 2 -->
                <div class="bg-white/10 backdrop-blur-xl
                            border border-white/20
                            rounded-xl p-4
                            flex items-center justify-between
                            shadow-xl
                            hover:scale-105 transition">
                    <i class="bi bi-brightness-high-fill text-white font-bold drop-shadow-[0_0_10px_rgba(255,255,255,0.5)] text-xl"></i>
                    <div class="text-lg font-bold text-green-400">ON</div>
                </div>

                <!-- CARD 3 -->
                <div class="bg-white/10 backdrop-blur-xl
                            border border-white/20
                            rounded-xl p-4
                            flex items-center justify-between
                            shadow-xl
                            hover:scale-105 transition">

                    <i class="bi bi-window text-white font-bold drop-shadow-[0_0_10px_rgba(255,255,255,0.5)] text-xl"></i>
                    <div class="text-lg font-bold text-green-400">UP</div>
                </div>

            </div>

        </div>

        <div class="flex overflow-x-auto gap-2 py-3">
            <a href="{{ route('rooms') }}" class="flex items-center justify-center bg-white/10 backdrop-blur-xl border border-white/20 shadow-xl hover:scale-105 transition rounded-full px-3 py-1"><i class="bi bi-plus text-white drop-shadow-[0_0_10px_rgba(255,255,255,0.5)]"></i></a>
            <!-- Les pièces se trouvant dans la maison -->
            <div class="bg-yellow-500 backdrop-blur-lg border border-gray-700 rounded-md px-3 py-1">
                Salon
            </div>

            <div class="bg-yellow-500 backdrop-blur-lg border border-gray-700 rounded-lg px-3 py-1">
                bedroom
            </div>

            <div class="bg-yellow-500 backdrop-blur-lg border border-gray-700 rounded-lg px-3 py-1">
                bathroom
            </div>

            <div class="bg-yellow-500 backdrop-blur-lg border border-gray-700 rounded-lg px-3 py-1">
                kitchen
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2 py-3 "><!-- Les pièces se trouvant dans la maison -->
            <div class="card relative z-10 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-6 mb-4 flex justify-between items-center gap-6 shadow-2xl hover:scale-[1.02] transition duration-300">
                <div>
                    <p class="text-gray-300 text-sm"><i class="bi bi-lightbulb"></i>Toutes les lumières</p>
                    <div class="data text-2xl font-bold text-red-500">OFF</div>
                </div>
                <div>
                    <button>
                        <i class="bi bi-toggle-off text-red-500 text-2xl"></i>
                    </button>
                </div>
            </div>
            <div class="card relative z-10 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-6 mb-4 flex justify-between items-center gap-6 shadow-2xl hover:scale-[1.02] transition duration-300">
                <div>
                    <p class="text-gray-300 text-sm"><i class="bi bi-lightbulb"></i>Salon</p>
                    <div class="data text-2xl font-bold text-green-500">ON</div>
                </div>
                <div>
                    <button>
                        <i class="bi bi-toggle-on text-green-500 text-2xl"></i>
                    </button>
                </div>
            </div>
            <div class="card relative z-10 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-6 mb-4 flex justify-between items-center gap-6 shadow-2xl hover:scale-[1.02] transition duration-300">
                <div>
                    <p class="text-gray-300 text-sm"><i class="bi bi-window"></i>Chambre 1</p>
                    <div class="data text-2xl font-bold text-green-500">UP</div>
                </div>
                <div>
                    <button>
                        <i class="bi bi-toggle-on text-green-500 text-2xl"></i>
                    </button>
                </div>
            </div>
            <div class="card relative z-10 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-6 mb-4 flex justify-between items-center gap-6 shadow-2xl hover:scale-[1.02] transition duration-300">
                <div>
                    <p class="text-gray-300 text-sm"><i class="bi bi-lightbulb"></i>Toutes les lumières</p>
                    <div class="data text-2xl font-bold text-green-500">ON</div>
                </div>
                <div>
                    <button>
                        <i class="bi bi-toggle-on text-green-500 text-2xl"></i>
                    </button>
                </div>
            </div>
        </div> --}}
    </div>
@endsection

{{-- la stack des scripts  --}}
@push('scripts')
@endpush
