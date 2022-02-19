<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <link rel="manifest" href="/manifest.json">
        <link href="images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
        <link href="{{ asset('webfonts/css/all.css') }}" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

        <!-- Scripts -->
        @routes
        <!-- <script src="/service-worker.js"></script> -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        {{-- <script src="{{ asset('js/scripts.js') }}"></script> --}}
        <script>
            // if ('serviceWorker' in navigator) {
            //     navigator.serviceWorker.register('service-worker.js');
            // }
        </script>
    </head>
    <body class="font-sans antialiased">
        @inertia

        @env ('local')
            <!-- <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script> -->
        @endenv
    </body>
</html>
