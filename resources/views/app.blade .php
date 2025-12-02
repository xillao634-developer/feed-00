<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('smart feedback portal') }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow p-4">
    <a href="/" class="font-bold">Smart Feedback Portal</a>
</nav>

<div class="container mx-auto p-6">
    @yield('content')
</div>

</body>
</html>
