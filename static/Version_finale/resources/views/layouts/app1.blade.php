<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="irstheme">
    <title> Allo Expert </title>
    <!-- CSS -->
    <link href="/alloexpert/assets/css/themify-icons.css" rel="stylesheet">
    <link href="/alloexpert/assets/css/flaticon.css" rel="stylesheet">
    <link href="/alloexpert/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/alloexpert/assets/css/animate.css" rel="stylesheet">
    <link href="/alloexpert/assets/css/style.css" rel="stylesheet">
    @yield('styles') <!-- Custom CSS styles for specific pages -->
</head>
<body>
    <!-- Header Section -->
    @include('layouts.header')


        @yield('content')


    <!-- Footer Section -->
    @include('layouts.footer')

    <!-- JavaScript -->
    <script src="/alloexpert/assets/js/jquery.min.js"></script>
    <script src="/alloexpert/assets/js/bootstrap.min.js"></script>
    <script src="/alloexpert/assets/js/jquery-plugin-collection.js"></script>
    <script src="/alloexpert/assets/js/script.js"></script>
    @yield('scripts') <!-- Custom JavaScript for specific pages -->
</body>
</html>
