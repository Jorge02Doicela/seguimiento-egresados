<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Application Title - Personalized for ISUS --}}
        <title>{{ config('app.name', 'Sistema Académico ISUS') }}</title>

        {{-- Favicon (Consider adding ISUS logo as favicon for browser tab branding) --}}
        {{-- For example: <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon"> --}}

        {{-- Preconnect for Google Fonts (Crucial for performance) --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        {{-- Google Fonts: Inter and Poppins (Using your defined fonts) --}}
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

        {{-- Importation of Vite styles and scripts (includes your Tailwind CSS) --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Your custom shadow-3xl is already defined in tailwind.config.js as "3xl" under boxShadow, so this custom style block can be removed. --}}
    </head>
    <body class="font-body text-text-primary bg-bg-primary antialiased min-h-screen">
        {{ $slot }}
    </body>
</html>
