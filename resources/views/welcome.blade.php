<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="msapplication-config" content="{{ config('app.url') }}/storage/media/favicons/browserconfig.xml">
        <meta name="theme-color" content="#ffffff">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="apple-touch-icon" sizes="120x120" href="{{ config('app.url') }}/storage/media/favicons/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ config('app.url') }}/storage/media/favicons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ config('app.url') }}/storage/media/favicons/favicon-16x16.png">
        <link rel="manifest" href="{{ config('app.url') }}/storage/media/favicons/site.webmanifest">
        <link rel="mask-icon" href="{{ config('app.url') }}/storage/media/favicons/safari-pinned-tab.svg">
        <link rel="shortcut icon" href="{{ config('app.url') }}/storage/media/favicons/favicon.ico">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->

    </head>
    <body class="antialiased">
        Coucou API
    </body>
</html>
