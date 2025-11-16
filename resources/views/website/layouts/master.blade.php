<!DOCTYPE html>
<html lang="en">

@include('website.layouts.head')

<body>
<!-- Navigation Bar -->
@include('website.layouts.header')

@yield('content')

<!-- Footer -->
@include('website.layouts.footer')

@include('website.layouts.scripts')

</body>

</html>
