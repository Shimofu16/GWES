<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/gwes-logo.png') }}">
        <title>{{ Config::get('app.name') ?? 'GWD' }}</title>

        <script src="https://cdn.tailwindcss.com"></script>
         <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />

         {{-- custom page styles --}}
         @stack('styles')
    </head>
    <body class="bg-[#fffdef]">
        @include('components.layouts.header')
        <main class="mt-[90px] lg:mt-[180px] container mx-auto">
            {{ $slot }}
        </main>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

        {{-- custom page scripts --}}
        @stack('scripts')
    </body>
</html>
