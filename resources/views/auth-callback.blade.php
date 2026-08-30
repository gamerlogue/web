<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Open Gamerlogue') }}</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 0; display: grid; place-items: center; min-height: 100vh; }
        main { max-width: 28rem; padding: 1.5rem; text-align: center; }
    </style>
</head>
<body>
<main>
    <h1>{{ __('Almost there') }}</h1>
    {{-- The code is in this page's URL and is useless without the verifier that never left the app. --}}
    <p>{{ __('Open the Gamerlogue app to finish signing in. You can close this page.') }}</p>
</main>
</body>
</html>
