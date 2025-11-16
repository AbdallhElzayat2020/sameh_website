@extends('website.layouts.master')
@section('title','Price Request')

@section('content')
    <!-- Page Header Section with Breadcrumb -->
    <section class="page-header-section">
        <div class="container">
            <div class="page-header-content">
                <nav class="breadcrumb-nav" aria-label="breadcrumb">
                    <ol class="breadcrumb-list">
                        <li class="breadcrumb-item">
                            <a href="index.html">HOME</a>
                        </li>
                        <li class="breadcrumb-separator">></li>
                        <li class="breadcrumb-item">
                            <a href="index.html#contact">CONTACT</a>
                        </li>
                        <li class="breadcrumb-separator">></li>
                        <li class="breadcrumb-item active" aria-current="page">PRICE REQUEST</li>
                    </ol>
                </nav>
                <h1 class="page-header-title">PRICE REQUEST</h1>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="page-content-section">
        <div class="container">
            <div class="row g-4">
                <!-- Form Section -->
                <div class="col-lg-8">
                    <form class="price-request-form" id="priceRequestForm">
                        <!-- Personal Information -->
                        <div class="form-section">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="firstName" class="form-label">First name</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName"
                                           value="Ahmed" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="lastName" class="form-label">Last name</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName" value="Soled"
                                           required>
                                </div>
                            </div>
                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           placeholder="Enter email here" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="projectName" class="form-label">Project Name</label>
                                    <input type="text" class="form-control" id="projectName" name="projectName"
                                           placeholder="Enter project name here" required>
                                </div>
                            </div>
                            <div class="row g-3 mt-2">
                                <div class="col-12">
                                    <label for="details" class="form-label">Details / information</label>
                                    <textarea class="form-control" id="details" name="details" rows="4"
                                              placeholder="Enter text here"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Services Selection -->
                        <div class="form-section">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="services" class="form-label">Select Services</label>
                                    <!-- <select class="form-control" id="services" name="services">
                                        <option selected disabled>select services</option>
                                        <option value="translation">Translation</option>
                                        <option value="dtp">Desktop Publishing (DTP)</option>
                                        <option value="interpreting">Interpreting</option>
                                        <option value="localization">Localization</option>
                                        <option value="subtitling">Subtitling / Closed Captioning</option>
                                        <option value="transcription">Transcription</option>
                                        <option value="transcreation">Transcreation</option>
                                    </select> -->
                                </div>
                            </div>
                            <div class="services-checkboxes mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="serviceTranslation"
                                           name="servicesList" value="translation">
                                    <label class="form-check-label" for="serviceTranslation">Translation</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="serviceDTP" name="servicesList"
                                           value="dtp" checked>
                                    <label class="form-check-label" for="serviceDTP">Desktop Publishing (DTP)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="serviceInterpreting"
                                           name="servicesList" value="interpreting">
                                    <label class="form-check-label" for="serviceInterpreting">Interpreting</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="serviceLocalization"
                                           name="servicesList" value="localization">
                                    <label class="form-check-label" for="serviceLocalization">Localization</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="serviceSubtitling"
                                           name="servicesList" value="subtitling">
                                    <label class="form-check-label" for="serviceSubtitling">Subtitling / Closed
                                        Captioning</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="serviceTranscription"
                                           name="servicesList" value="transcription">
                                    <label class="form-check-label" for="serviceTranscription">Transcription</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="serviceTranscreation"
                                           name="servicesList" value="transcreation">
                                    <label class="form-check-label" for="serviceTranscreation">Transcreation</label>
                                </div>
                            </div>
                        </div>

                        <!-- Time and Date Selection -->
                        <div class="form-section">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="timeZone" class="form-label">Time Zone</label>
                                    <select class="form-control" id="timeZone" name="timeZone">
                                        <option value="">Select time zone</option>
                                        <option value="UTC">UTC</option>
                                        <option value="EST">EST (Eastern Standard Time)</option>
                                        <option value="PST">PST (Pacific Standard Time)</option>
                                        <option value="GMT">GMT (Greenwich Mean Time)</option>
                                        <option value="CET">CET (Central European Time)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Required Start Date -->
                            <div class="row g-3 mt-2">
                                <div class="col-12">
                                    <label class="form-label">Required Start Date</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="startDate" name="startDate">
                                        <span class="input-group-icon">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="time" class="form-control" id="startTime" name="startTime">
                                        <span class="input-group-icon">
                                            <i class="far fa-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Required Delivery Date -->
                            <div class="row g-3 mt-2">
                                <div class="col-12">
                                    <label class="form-label">Required Delivery Date</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="deliveryDate" name="deliveryDate">
                                        <span class="input-group-icon">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="time" class="form-control" id="deliveryTime" name="deliveryTime">
                                        <span class="input-group-icon">
                                            <i class="far fa-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment and Files -->
                        <div class="form-section">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="paymentCurrency" class="form-label">Your Preferred Payment
                                        Currency</label>
                                    <input type="text" class="form-control" id="paymentCurrency" name="paymentCurrency"
                                           placeholder="Your Preferred Payment Currency">
                                </div>
                                <div class="col-12">
                                    <label for="fileUpload" class="form-label">Upload the files</label>
                                    <div class="file-upload-wrapper">
                                        <input type="file" class="form-control file-input" id="fileUpload"
                                               name="fileUpload" multiple>
                                        <span class="file-upload-icon">
                                            <i class="fas fa-arrow-up"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-section mt-4">
                            <button type="submit" class="price-request-submit-btn">
                                Send Request
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Instructions Panel -->
                <div class="col-lg-4">
                    <div class="instructions-panel">
                        <h3 class="instructions-title">HOW TO SEND US A REQUEST?</h3>
                        <ol class="instructions-list">
                            <li>Enter your personal information (First name, Last name, Email, Project Name)</li>
                            <li>Provide details about your project in the "Details / information" field</li>
                            <li>Select the service type from the dropdown menu</li>
                            <li>Check the specific services you need from the list</li>
                            <li>Select your time zone</li>
                            <li>Choose your required start date and time</li>
                            <li>Choose your required delivery date and time</li>
                            <li>Enter your preferred payment currency</li>
                            <li>Upload any relevant files for your project</li>
                            <li>Click "Send Request" to submit your request</li>
                        </ol>
                        <p class="instructions-note">
                            This request is sent to the project manager, who will then send you a quote or an order
                            confirmation.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
