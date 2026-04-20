<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartHome - {{ $title ?? 'Dashboard' }}</title>
    {{-- tailwindcss cdn --}}
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-900 text-white">
    <div class="min-h-screen">
        @yield('content')
    </div>
    @stack('scripts')
</body>
