<nav class="navbar">
    <div class="container">
        <div class="nav-wrapper">
            <!-- Logo -->
            <div class="logo">
                <img src="{{asset('assets/website/images/logo.png')}}" alt="Words Tie Logo" class="logo-img"/>
            </div>

            <!-- Navigation Links -->
            <ul class="nav-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#industries">Industries</a></li>
                <li><a href="#iso">ISO</a></li>
                <li><a href="#testimonials">Testimonials</a></li>
            </ul>

            <!-- Contact Button -->
            <a href="#" class="contact-btn text-decoration-none">Contact Us</a>

            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</nav>
