@extends('website.layouts.master')
@section('title', 'Price Request')

@push('css')
    <style>
        .price-request-form select,
        .price-request-form select option {
            color: #0f172a;
            background-color: #fff;
        }
    </style>
@endpush

@section('content')
    <section class="page-header-section">
        <div class="container">
            <div class="page-header-content">
                <nav class="breadcrumb-nav" aria-label="breadcrumb">
                    <ol class="breadcrumb-list">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">HOME</a>
                        </li>
                        <li class="breadcrumb-separator">></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}#contact">CONTACT</a>
                        </li>
                        <li class="breadcrumb-separator">></li>
                        <li class="breadcrumb-item active" aria-current="page">PRICE REQUEST</li>
                    </ol>
                </nav>
                <h1 class="page-header-title">PRICE REQUEST</h1>
            </div>
        </div>
    </section>

    <section class="page-content-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
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

                    <form class="price-request-form" id="priceRequestForm" method="POST"
                        action="{{ route('price-request.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-section">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">First name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="{{ old('first_name') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="{{ old('last_name') }}" required>
                                </div>
                            </div>
                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email') }}" placeholder="Enter email here" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="project_name" class="form-label">Project Name</label>
                                    <input type="text" class="form-control" id="project_name" name="project_name"
                                        value="{{ old('project_name') }}" placeholder="Enter project name here" required>
                                </div>
                            </div>
                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label for="source_language" class="form-label">Source Language</label>
                                    <input type="text" class="form-control" id="source_language" name="source_language"
                                        value="{{ old('source_language') }}" placeholder="e.g. Arabic" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="target_language" class="form-label">Target Language</label>
                                    <input type="text" class="form-control" id="target_language" name="target_language"
                                        value="{{ old('target_language') }}" placeholder="e.g. English" required>
                                </div>
                            </div>
                            <div class="row g-3 mt-2">
                                <div class="col-12">
                                    <label for="description" class="form-label">Details / information</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter text here"
                                        required>{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Select Services</label>
                                </div>
                            </div>
                            <div class="services-checkboxes mt-3">
                                @forelse ($services as $service)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            id="service-{{ $service->id }}" name="services[]"
                                            value="{{ $service->id }}"
                                            @checked(in_array($service->id, old('services', [])))>
                                        <label class="form-check-label" for="service-{{ $service->id }}">
                                            {{ $service->name }}
                                        </label>
                                    </div>
                                @empty
                                    @foreach ($fallbackServices as $index => $serviceName)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                id="fallback-service-{{ $index }}" name="services[]"
                                                value="{{ $serviceName }}"
                                                @checked(in_array($serviceName, old('services', [])))>
                                            <label class="form-check-label" for="fallback-service-{{ $index }}">
                                                {{ $serviceName }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endforelse
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="time_zone" class="form-label">Time Zone</label>
                                    <select class="form-control" id="time_zone" name="time_zone" required>
                                        <option value="" disabled selected>Select time zone</option>
                                        @foreach ($timeZones as $zone)
                                            <option value="{{ $zone }}" @selected(old('time_zone') === $zone)>
                                                {{ $zone }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 mt-2">
                                <div class="col-12">
                                    <label class="form-label">Required Start Date</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                            value="{{ old('start_date') }}" required>
                                        <span class="input-group-icon">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="time" class="form-control" id="start_time" name="start_time"
                                            value="{{ old('start_time') }}" required>
                                        <span class="input-group-icon">
                                            <i class="far fa-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mt-2">
                                <div class="col-12">
                                    <label class="form-label">Required Delivery Date</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                            value="{{ old('end_date') }}" required>
                                        <span class="input-group-icon">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="time" class="form-control" id="end_time" name="end_time"
                                            value="{{ old('end_time') }}" required>
                                        <span class="input-group-icon">
                                            <i class="far fa-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="preferred_payment_type" class="form-label">Preferred Payment Method</label>
                                    <input type="text" class="form-control" id="preferred_payment_type"
                                        name="preferred_payment_type" value="{{ old('preferred_payment_type') }}"
                                        placeholder="e.g. Bank transfer" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="currency" class="form-label">Preferred Currency</label>
                                    <input type="text" class="form-control" id="currency" name="currency"
                                        value="{{ old('currency') }}" placeholder="e.g. USD" required>
                                </div>
                            </div>

                            <div class="row g-3 mt-2">
                                <div class="col-12">
                                    <label for="attachments" class="form-label">Upload the files</label>
                                    <div class="file-upload-wrapper">
                                        <input type="file" class="form-control file-input" id="attachments"
                                            name="attachments[]" accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip"
                                            multiple>
                                        <span class="file-upload-icon">
                                            <i class="fas fa-arrow-up"></i>
                                        </span>
                                    </div>
                                    <small class="text-muted d-block mt-1">Images and documents up to 20MB each.</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-section mt-4">
                            <button type="submit" class="price-request-submit-btn">
                                Send Request
                            </button>
                        </div>
                    </form>
                </div>

                <div class="col-lg-4">
                    <div class="instructions-panel">
                        <h3 class="instructions-title">HOW TO SEND US A REQUEST?</h3>
                        <ol class="instructions-list">
                            <li>Fill in your personal details and project name</li>
                            <li>Select source and target languages</li>
                            <li>Describe your project requirements</li>
                            <li>Choose the services you need</li>
                            <li>Set your timeframe and time zone</li>
                            <li>Select payment method and currency</li>
                            <li>Upload any reference files</li>
                            <li>Submit the form to notify our project managers</li>
                        </ol>
                        <p class="instructions-note">
                            Once we receive your request, our team reviews it and shares the best quote or order confirmation
                            with you.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
