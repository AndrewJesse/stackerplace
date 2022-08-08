<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">

        <title>{{ $title ?? 'Stackerplace' }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <livewire:styles />

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans text-sm text-gray-900 bg-gray-background">
        <header class="flex flex-col items-center justify-between px-8 py-4 md:flex-row">
            <a href="/"><img src="{{ asset('img/logo.svg') }}" alt="logo"></a>
            <div class="flex items-center mt-2 md:mt-0">
                @if (Route::has('login'))
                    <div class="px-6 py-4">
                        @auth
                            <div class="flex items-center space-x-4">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log out') }}
                                    </a>
                                </form>

                                <livewire:comment-notifications />
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
                @auth
                    <a href="#">
                        <img src="{{ auth()->user()->getAvatar() }}" alt="avatar" class="w-10 h-10 rounded-full">
                    </a>
                @endauth
            </div>
        </header>

        <main class="container flex flex-col mx-auto max-w-custom md:flex-row">
            <div class="mx-auto w-70 md:mx-0 md:mr-5">
                <div
                    class="mt-16 bg-white border-2 md:sticky md:top-8 border-blue rounded-xl"
                    style="
                          border-image-source: linear-gradient(to bottom, rgba(50, 138, 241, 0.22), rgba(99, 123, 255, 0));
                            border-image-slice: 1;
                            background-image: linear-gradient(to bottom, #ffffff, #ffffff), linear-gradient(to bottom, rgba(50, 138, 241, 0.22), rgba(99, 123, 255, 0));
                            background-origin: border-box;
                            background-clip: content-box, border-box;
                    "
                >
                    <div class="px-6 py-2 pt-6 text-center">
                        <h3 class="text-base font-semibold">Add an idea</h3>
                        <p class="mt-4 text-xs">
                            @auth
                                Let us know what you would like and we'll take a look over!
                            @else
                                Please login to create an idea.
                            @endauth
                        </p>
                    </div>

                    <livewire:create-idea />
                </div>
                <div class="px-6 py-2 pt-6 text-center">
                    <h3 class="text-base font-semibold">Featured Youtube Playlist</h3>
                    <iframe width="234" height="132" src="https://www.youtube.com/embed/videoseries?list=PL_OI0i6ugUP5PmNionUsvOTV_AXoDiBrZ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>

            <div class="w-full px-2 md:px-0 md:w-175">
                <livewire:status-filters />

                <div class="mt-8">
                    {{ $slot }}
                </div>
            </div>
        </main>


        @if (session('success_message'))
            <x-notification-success
                :redirect="true"
                message-to-display="{{ (session('success_message')) }}"
            />
        @endif

        @if (session('error_message'))
            <x-notification-success
                type="error"
                :redirect="true"
                message-to-display="{{ (session('error_message')) }}"
            />
        @endif

        <livewire:scripts />

    </body>
</html>
