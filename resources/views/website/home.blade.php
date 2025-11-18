@extends('website.layouts.master')
@section('title', 'Home')

@section('content')

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="hero-content">
            <p class="welcome-text">Welcome To</p>
            <div class="hero-logo-wrapper">
                <img src="{{ asset('assets/website/images/logo_big.png') }}" alt="Words Tie Logo" class="hero-logo" />
            </div>
            <p class="translation-text">Translation Services</p>
        </div>

        <!-- Decorative Stars -->
        <div class="star star-top-right">
            <img src="{{ asset('assets/website/images/small_blue.png') }}" alt="star decoration" />
        </div>
        <div class="star star-bottom-left">
            <img src="{{ asset('assets/website/images/small_blue.png') }}" alt="star decoration" class="star-large" />
            <img src="{{ asset('assets/website/images/small_white.png') }}" alt="star decoration" class="star-small" />
        </div>

        <!-- Admin Sign In Link -->
        <a href="{{ route('login') }}" class="admin-link">
            Sign in by Admin
            <span class="admin-icon">
                <img src="{{ asset('assets/website/images/bit_blue.png') }}" alt="external link" />
            </span>
        </a>
    </section>

    <!-- Bottom Section with Slogan -->
    <section class="slogan-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <h1 class="slogan-text">
                        IGNITE BRAND UNFORGETTABLE WITH CREATIVITY
                    </h1>
                    <p class="slogan-description">
                        AI Artificial Intelligence is a branch of computer science that
                        focuses on the development of intelligent machines that can
                        perform tasks that typically require human intelligence.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section" id="about">
        <div class="container">
            <div class="row gy-5 align-items-center about-wrapper">
                <div class="col-lg-5">
                    <div class="about-visual rounded-4 overflow-hidden shadow-lg">
                        <!-- <img src="images/about-left.svg"
                                                                                                                                                                                alt="Stacked cards showing real-world solutions and proven results"
                                                                                                                                                                                class="img-fluid w-100" /> -->
                        <img src="{{ asset('assets/website/images/small_about.png') }}" alt=""
                            class="img-fluid w-100 mt-3" />
                        <img src="{{ asset('assets/website/images/small_about.png') }}" alt=""
                            class="img-fluid w-100 mt-3" />
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="about-card position-relative rounded-4 shadow-lg">
                        <img src="{{ asset('assets/website/images/about-right.svg') }}" alt="" class="about-card-bg"
                            aria-hidden="true" />
                        <div class="about-card-content">
                            <div class="small-tag">
                                <span class="tag-icon"></span>
                                <span>About Us</span>
                            </div>
                            <h3 class="features-title">SHAPE YOUR BRAND'S STORY WITH ARTISTRY</h3>
                            <p class="features-desc">
                                Business Intelligence is a branch of computer science that focuses on the development of
                                intelligent machines that can perform tasks that typically require human intelligence.
                            </p>
                            <ul class="feature-list list-unstyled mb-0">
                                <li class="feature-item d-flex gap-3 align-items-start">
                                    <span
                                        class="feature-icon rounded-circle d-inline-flex align-items-center justify-content-center">✓</span>
                                    <div class="feature-content">
                                        <span class="feature-label">VISION</span>
                                        <p class="feature-copy mb-0">
                                            Business Intelligence is a branch of computer science that focuses on the
                                            development of intelligent machine.
                                        </p>
                                    </div>
                                </li>
                                <li class="feature-item d-flex gap-3 align-items-start">
                                    <span
                                        class="feature-icon rounded-circle d-inline-flex align-items-center justify-content-center">✓</span>
                                    <div class="feature-content">
                                        <span class="feature-label">MISSION</span>
                                        <p class="feature-copy mb-0">
                                            Business Intelligence is a branch of computer science that focuses on the
                                            development of intelligent machine.
                                        </p>
                                    </div>
                                </li>
                                <li class="feature-item d-flex gap-3 align-items-start">
                                    <span
                                        class="feature-icon rounded-circle d-inline-flex align-items-center justify-content-center">✓</span>
                                    <div class="feature-content">
                                        <span class="feature-label">WHY US</span>
                                        <p class="feature-copy mb-0">
                                            Business Intelligence is a branch of computer science that focuses on the
                                            development of intelligent machine.
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php
        $serviceItems = collect($homeServices ?? []);
        $serviceChunkSize = max(1, (int) ceil($serviceItems->count() / 2));
        $serviceColumns = $serviceItems->chunk($serviceChunkSize);
        $activeService = $serviceItems->first();
        $defaultServiceTitle = $activeService['name'] ?? 'Translation';
        $defaultServiceDescription =
            $activeService['description'] ??
            'AI Artificial Intelligence is a branch of computer science that focuses on the development of intelligent machines that
can perform tasks that typically require human intelligence.';
        $serviceItemIndex = 0;
    @endphp

    <!-- Services Section -->
    <section class="services-section" id="services">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="services-header mb-5">
                        <div class="small-tag mb-3">
                            <span class="tag-icon"></span>
                            <span>Services</span>
                        </div>
                        <h2 class="services-title">OUR SERVICES</h2>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <!-- Services List -->
                <div class="col-lg-8">
                    <div class="row g-3">
                        @forelse ($serviceColumns as $column)
                            <div class="col-md-6">
                                @foreach ($column as $service)
                                    @php
                                        $isFirstService = $serviceItemIndex === 0;
                                        $serviceItemIndex++;
                                    @endphp
                                    <div class="service-item mt-2 {{ $isFirstService ? 'active' : '' }}"
                                        data-service="{{ $service['id'] ?? $serviceItemIndex }}"
                                        data-title="{{ strtoupper($service['name']) }}"
                                        data-description="{{ e($service['description']) }}">
                                        <div class="service-icon-wrapper">
                                            <div class="service-icon"></div>
                                        </div>
                                        <span class="service-name">{{ strtoupper($service['name']) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted">Services will be available soon.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                <!-- Description Panel -->
                <div class="col-lg-4">
                    <div class="service-description-panel">
                        <h3 class="service-description-title" id="service-title">
                            {{ strtoupper($defaultServiceTitle) }}
                        </h3>
                        <div class="service-description-divider"></div>
                        <p class="service-description-text" id="service-description">
                            {{ $defaultServiceDescription }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        @once
            <script>
                window.industriesData = @json($industries);
            </script>
        @endonce
    @endpush

    <!-- Industries Section -->
    @if (false)

        <section class="industries-section" id="industries">
            <div class="container">
                <!-- Header -->
                <div class="row mb-5">
                    <div class="col-lg-8">
                        <div class="industries-header">
                            <div class="small-tag mb-3">
                                <span class="tag-icon"></span>
                                <span>Industries</span>
                            </div>
                            <h2 class="industries-title">TRANSFORMING BUSINESSES TO LEAD THEIR INDUSTRIES</h2>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ route('price-request') }}" class="price-request-btn text-decoration-none">
                            Price Request
                            <span class="price-btn-icon">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 1L15 8L8 15M15 8H1" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Industry Filter Buttons -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="industry-filters d-flex flex-wrap gap-3" id="industry-filters">
                            @forelse ($industries as $index => $industry)
                                <button class="industry-filter-btn {{ $index === 0 ? 'active' : '' }}"
                                    data-industry="{{ $industry['slug'] }}" data-industry-id="{{ $industry['id'] }}">
                                    <span class="filter-icon">✦</span>
                                    <span>{{ $industry['name'] }}</span>
                                </button>
                            @empty
                                <p class="text-muted">No industries available.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="row g-4 mb-5">
                    <!-- Left Panel - Image -->
                    <div class="col-lg-7">
                        <div class="industry-visual-panel position-relative rounded-4 overflow-hidden">
                            <div class="industry-visual-placeholder" id="industry-visual-placeholder"
                                @if ($industries->isNotEmpty() && $industries->first()['image']) style="background-image: url('{{ $industries->first()['image'] }}'); background-size: cover;
                        background-position: center; background-repeat: no-repeat;" @endif>
                                <div class="industry-visual-overlay">
                                    <h3 class="industry-visual-title" id="industry-visual-title">
                                        {{ $industries->isNotEmpty() ? $industries->first()['name'] : 'Industries' }}
                                    </h3>
                                    <div class="industry-visual-line"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Panel - Services List -->
                    <div class="col-lg-5">
                        <div class="industry-services-panel rounded-4">
                            <h3 class="industry-services-title" id="industry-services-title">
                                {{ $industries->isNotEmpty() ? strtoupper($industries->first()['name']) : 'INDUSTRIES' }}
                            </h3>
                            <div class="industry-services-divider"></div>
                            <ul class="industry-services-list list-unstyled mb-0" id="industry-services-list">
                                @if ($industries->isNotEmpty())
                                    @foreach ($industries->first()['options'] as $option)
                                        <li class="industry-service-item">
                                            <span class="service-arrow">→</span>
                                            <span>{{ $option }}</span>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="industry-description">
                            <p class="industry-description-text" id="industry-description-text">
                                {{ $industries->isNotEmpty()
                                    ? $industries->first()['description']
                                    : 'Industry description will
                                                                                                                        be available soon.' }}
                            </p>
                            <ul class="industry-description-list" id="industry-description-list">
                                @if ($industries->isNotEmpty())
                                    @foreach ($industries->first()['options'] as $option)
                                        <li>{{ $option }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif


    <!-- Valuable Customers Section -->
    <section class="customers-section" id="testimonials">
        <div class="container">
            <!-- Header and Stats Row -->
            <div class="row mb-5">
                <div class="col-lg-7">
                    <div class="customers-header mb-4">
                        <div class="small-tag mb-3">
                            <span class="tag-icon"></span>
                            <span>Valuable Customers</span>
                        </div>
                        <h2 class="customers-title">
                            Trusted by Visionary Startups & <span class="highlight-blue">Innovators<span
                                    class="highlight-diamond">◆</span></span>
                        </h2>
                    </div>
                    <!-- Customer Rating -->
                    <div class="customer-rating d-flex align-items-center gap-3">
                        <div class="rating-avatars d-flex">
                            <div class="rating-avatar"></div>
                            <div class="rating-avatar"></div>
                            <div class="rating-avatar"></div>
                        </div>
                        <div class="rating-content">
                            <div class="rating-score d-flex align-items-center gap-2 mb-1">
                                <span class="rating-number">4.8</span>
                                <div class="rating-stars">
                                    <span class="star-icon">★</span>
                                    <span class="star-icon">★</span>
                                    <span class="star-icon">★</span>
                                    <span class="star-icon">★</span>
                                    <span class="star-icon">★</span>
                                </div>
                            </div>
                            <p class="rating-text mb-0">Customer Rating Of TechAI</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="stats-grid">
                        <div class="stat-item stat-item-highlight">
                            <div class="stat-number">420+</div>
                            <div class="stat-label">Projects Delivered</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">14+</div>
                            <div class="stat-label">Years in UX/UI</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">300+</div>
                            <div class="stat-label">Clients Worldwide</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">+250</div>
                            <div class="stat-label">Client Rating</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Separator Line -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="customers-separator"></div>
                </div>
            </div>

            <!-- Client Logos -->
            <div class="row">
                <div class="col-12">
                    <div class="client-logos d-flex flex-wrap align-items-center justify-content-center gap-5">
                        <div class="client-logo">Zenza</div>
                        <div class="client-logo">innovi</div>
                        <div class="client-logo">techtid</div>
                        <div class="client-logo">Lum Lab</div>
                        <div class="client-logo">LAUNCHLAN</div>
                        <div class="client-logo">Lum Lab</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ISO Certification Section -->
    @if ($iosImages->isNotEmpty())
        <section class="iso-section" id="iso">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="iso-header mb-5">
                            <div class="small-tag mb-3">
                                <span class="tag-icon"></span>
                                <span>ISO</span>
                            </div>
                            <h2 class="iso-title">ISO CERTIFICATION</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="iso-badges d-flex flex-wrap justify-content-center gap-5">
                            <!-- Badge 1 -->
                            @foreach ($iosImages as $image)
                                <div class="iso-badge-item">
                                    <img src="{{ asset('uploads/' . $image->img_path) }}" alt="{{ $image->title }}"
                                        class="iso-badge-image">
                                    <div class="iso-badge-details">
                                        <p class="iso-cert-number">ISO 17100:2015</p>
                                        <p class="iso-cert-id">CERTIFICATION NO. TS-2407094</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif


    <!-- Testimonials Section -->
    <section class="testimonials-section" id="testimonials">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="testimonials-header">
                        <div class="small-tag mb-3">
                            <span class="tag-icon"></span>
                            <span>Testimonials</span>
                        </div>
                        <h2 class="testimonials-title">WHAT OUR CLIENTS SAY</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="testimonials-carousel-wrapper position-relative">
                        <div class="swiper testimonials-swiper" id="testimonialsSwiper">
                            <div class="swiper-wrapper">
                                @forelse ($testimonials as $testimonial)
                                    <div class="swiper-slide">
                                        <div class="testimonial-card">

                                            <p class="testimonial-text">
                                                "{{ $testimonial->description }}"
                                            </p>
                                            <div class="testimonial-author">
                                                <div class="author-avatar"></div>
                                                <div class="author-info">
                                                    <div class="author-name">{{ $testimonial->name }}</div>
                                                    <div class="author-role">Client</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="swiper-slide">
                                        <div class="testimonial-card text-center">
                                            <p class="testimonial-text">Testimonials will appear soon.</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <!-- Navigation Arrows -->
                        <div class="testimonials-nav">
                            <button class="testimonial-nav-btn testimonial-prev">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                            <button class="testimonial-nav-btn testimonial-next active">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Decorative Elements -->
        <div class="testimonials-decorative">
            <div class="decorative-shape shape-1"></div>
            <div class="decorative-shape shape-2"></div>
        </div>
    </section>

    <!-- Contact Us Section -->
    <section class="contact-section" id="contact">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="contact-header">
                        <div class="small-tag mb-3">
                            <span class="tag-icon"></span>
                            <span>Contact us</span>
                        </div>
                        <h2 class="contact-title">LET'S TALK</h2>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <!-- Contact Form -->
                <div class="col-lg-7">
                    <div class="contact-form-panel rounded-4">
                        <h3 class="contact-form-title">GET IN TOUCH</h3>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="contact-form" method="POST" action="{{ route('contact.store') }}">
                            @csrf
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="contact_name" class="form-label">YOUR NAME</label>
                                    <input type="text" class="form-control" id="contact_name" name="name"
                                        placeholder="your name..." value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="contact_email" class="form-label">YOUR EMAIL</label>
                                    <input type="email" class="form-control" id="contact_email" name="email"
                                        placeholder="your email..." value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="contact_phone" class="form-label">PHONE</label>
                                    <input type="text" class="form-control" id="contact_phone" name="phone"
                                        placeholder="your phone..." value="{{ old('phone') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="contact_subject" class="form-label">SUBJECT</label>
                                    <input type="text" class="form-control" id="contact_subject" name="subject"
                                        placeholder="your subject..." value="{{ old('subject') }}">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="contact_message" class="form-label">MESSAGE</label>
                                <textarea class="form-control" id="contact_message" name="message" rows="5" placeholder="write message.."
                                    required>{{ old('message') }}</textarea>
                            </div>
                            <button type="submit" class="contact-submit-btn">
                                SUBMIT
                                <span class="submit-arrow">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
                <!-- Contact Information -->
                <div class="col-lg-5">
                    <div class="contact-info">
                        <h3 class="contact-info-title">CONTACT US</h3>
                        <div class="contact-info-list">
                            <div class="contact-info-item">
                                <div class="contact-icon-wrapper">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <circle cx="12" cy="10" r="3" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="contact-info-content">
                                    <div class="contact-info-label">Address</div>
                                    <div class="contact-info-value">2972 WESTHEIMER RD. SANTA</div>
                                </div>
                            </div>
                            <div class="contact-info-item">
                                <div class="contact-icon-wrapper">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M22 6L12 13L2 6" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="contact-info-content">
                                    <div class="contact-info-label">Email Address</div>
                                    <div class="contact-info-value">MM.ONS@EXAMPLE.COM</div>
                                </div>
                            </div>
                            <div class="contact-info-item">
                                <div class="contact-icon-wrapper">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M22 16.92V19.92C22.0011 20.1985 21.9441 20.4742 21.8325 20.7292C21.7209 20.9841 21.5573 21.2126 21.3528 21.3992C21.1483 21.5857 20.9074 21.7261 20.6446 21.8112C20.3819 21.8962 20.1035 21.924 19.83 21.892C16.7432 21.5051 13.787 20.3059 11.19 18.39C8.77382 16.7065 6.72533 14.4909 5.19 11.89C3.28186 9.22397 2.10149 6.21865 1.73 3.09C1.69804 2.81748 1.72584 2.53962 1.81081 2.27723C1.89578 2.01484 2.03596 1.77426 2.22219 1.56989C2.40841 1.36552 2.63663 1.20184 2.89164 1.09011C3.14665 0.978374 3.42234 0.921021 3.7 0.921H6.7C7.23652 0.920066 7.75296 1.12788 8.14458 1.50373C8.5362 1.87958 8.77497 2.39722 8.81 2.94C8.94497 4.66154 9.35047 6.35047 10.01 7.94C10.2139 8.44814 10.3421 8.9863 10.39 9.54C10.4309 10.0108 10.3437 10.4826 10.1375 10.9094C9.9313 11.3362 9.61419 11.7025 9.22 11.97L7.09 13.1C8.51484 15.9071 10.5929 18.3852 13.19 20.36L14.26 18.23C14.5286 17.8395 14.8954 17.5253 15.3224 17.3219C15.7494 17.1185 16.221 17.0329 16.69 17.07C18.1904 17.2088 19.6791 17.5998 21.09 18.23L22.22 16.1C22.4878 15.7058 22.8541 15.3887 23.2809 15.1825C23.7077 14.9763 24.1795 14.8891 24.65 14.93C25.1928 14.965 25.7104 15.2038 26.0863 15.5954C26.4621 15.987 26.67 16.5035 26.67 17.04H26.68Z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="contact-info-content">
                                    <div class="contact-info-label">Phone number</div>
                                    <div class="contact-info-value">(704) 555-0127</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Price Request Section -->
    <section class="price-request-section">
        <div class="container">
            <div class="price-request-panel rounded-4">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="price-request-content">
                            <h2 class="price-request-title">PRICE REQUEST</h2>
                            <p class="price-request-text">
                                Business Intelligence is a branch of computer science that focuses on the development of
                                intelligent machines that can perform tasks that typically require intelligence Business
                                Intelligence is a branch of computer science
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ route('price-request') }}" class="price-request-circle-btn">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 8L20 16L12 24" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
