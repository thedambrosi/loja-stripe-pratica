<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gray-50 antialiased dark:bg-neutral-950">
        <div class="mx-auto max-w-5xl px-6 py-10">
            <header class="mb-10">
                <a href="{{ route('home') }}" class="text-xl font-semibold text-gray-900 dark:text-white">
                    Loja Stripe Prática
                </a>
            </header>

            {{ $slot }}
        </div>
    </body>
</html>
