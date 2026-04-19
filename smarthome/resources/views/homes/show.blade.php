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
        <div class="mb-6">
            <h1 class="text-xl font-semibold mb-2"><i class="bi bi-house-door-fill text-white mr-2"></i>{{ $maison->nom }}</h1>
            <p class="text-gray-200 mb-4"><i class="bi bi-geo-alt-fill text-white mr-2"></i>{{ $maison->adresse }}, {{ $maison->ville }}, {{ $maison->pays }}</p>
        </div>
        {{-- card temperature like meteo card --}}
        <div class="relative bg-gradient-to-br from-[#0f172a] to-[#020617] p-4 mb-4 rounded-2xl overflow-hidden">
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
        </div>
    </div>
@endsection

{{-- la stack des scripts  --}}
@push('scripts')
@endpush
