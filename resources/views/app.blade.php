<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--suppress HtmlRequiredTitleElement – Handled by Inertia -->
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <meta name="description" content="Maicol07 Account is a service that allows you to authenticate with a single account on all Maicol07 services.">
    <meta name="keywords" content="maicol07, account, sso, auth, openid, connect, authentication, username, password">
    <meta name="author" content="maicol07">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anta&family=Rethink+Sans:ital,wght@0,400..800;1,400..800&family=Reddit+Sans:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{Vite::asset('resources/images/favicon/favicon-96x96.png')}}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{Vite::asset('resources/images/favicon/favicon.svg')}}" />
    <link rel="shortcut icon" href="{{Vite::asset('resources/images/favicon/favicon.ico')}}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{Vite::asset('resources/images/favicon/apple-touch-icon.png')}}" />
    <meta name="apple-mobile-web-app-title" content="Maicol07 Account" />

    <x-turnstile::script meta />

    @vite('resources/scss/app.scss')
    @inertiaHead
</head>
<body>
@inertia
@vite('resources/ts/app.ts')
<launchnotes-embed
        data-id="emb_app_zERc2mr5Cms48"
        data-token="jVSJSzR2zpbug"
        data-embed-type="popup"
        id="ln-embed"
></launchnotes-embed>
<script
        id="ln-embed-script"
        src="https://embed.launchnotes.io/embed_v2/latest/embed.js"
        type="text/javascript"
></script>
<script type="text/javascript" charset="UTF-8" src="//cdn.cookie-script.com/s/8a5df0c415c5c4034133586baeb1d872.js"></script>
<script type="text/javascript" id="zsiqchat">var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || {widgetcode: "siq1e91335b4a1aa070a5173b6d2b4e267f6cce11e4485a82255602d7a7a0604e9f", values:{},ready:function(){}};var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;s.src="https://salesiq.zohopublic.eu/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);</script>
</body>
</html>
