<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Daily Task Planner</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite('resources/css/app.css')

    @livewireStyles
</head>

<body class="antialiased bg-gray-100 font-sans min-h-screen flex flex-col items-center py-8">
    @livewire('flash-message')

    <div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-center text-gray-800 mb-10 md:mb-12">Mon Planificateur de
            Tâches Journalières</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12 items-start"> {{-- Ajout de items-start ici --}}
            <div class="lg:col-span-1 bg-white p-6 sm:p-8 rounded-lg shadow-xl border border-gray-200">
                @livewire('task-form')
            </div>
            <div class="lg:col-span-2 bg-white p-6 sm:p-8 rounded-lg shadow-xl border border-gray-200">
                @livewire('task-list')
            </div>
        </div>
    </div>

    @livewireScripts
</body>

</html>