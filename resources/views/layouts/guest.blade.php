<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Application Title - Personalized for ISUS --}}
        <title>{{ config('app.name', 'Sistema Académico ISUS') }}</title>

        {{-- Favicon (Consider adding ISUS logo as favicon for browser tab branding) --}}
        {{-- <link rel="icon" href="{{ asset('path/to/your/favicon.ico') }}" type="image/x-icon"> --}}

        {{-- Preconnect for Google Fonts (Crucial for performance) --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        {{-- Google Fonts: Montserrat (Bold/SemiBold/Medium) and Open Sans (Regular/Light) --}}
        {{-- Ensuring all necessary weights are preloaded for optimal display --}}
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

        {{-- Importation of Vite styles and scripts (includes your Tailwind CSS) --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Custom CSS for shadows if not defined in Tailwind config (Optional, can be added to app.css) --}}
        <style>
            .shadow-3xl {
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35), 0 15px 30px -5px rgba(0, 0, 0, 0.25);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </body>
</html>
