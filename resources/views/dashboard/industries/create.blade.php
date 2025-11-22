@extends('dashboard.layouts.master')
@section('title', 'Create Industry')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header border-0 bg-transparent pb-3">
            <h4 class="mb-1">Create Industry</h4>
            <p class="mb-0 text-muted">Add a new industry with its options.</p>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('dashboard.industries.store') }}" enctype="multipart/form-data">
                @csrf
                @include('dashboard.industries.partials.form')
                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="{{ route('dashboard.industries.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Industry</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css" rel="stylesheet">
    <style>
        html {
            direction: ltr !important;
        }

        /* Summernote dropdown fixes */
        .note-dropdown-menu {
            z-index: 9999 !important;
            position: absolute !important;
        }

        .note-popover {
            z-index: 9998 !important;
        }

        .note-editor.note-frame {
            z-index: 1 !important;
        }

        .note-dropdown-menu .dropdown-item {
            padding: 0.25rem 1rem;
            font-size: 0.875rem;
        }

        .note-dropdown-menu .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        /* Fix for Bootstrap 5 compatibility */
        .note-btn-group .dropdown-toggle::after {
            display: inline-block;
            margin-left: 0.255em;
            vertical-align: 0.255em;
            content: "";
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
        }

        /* Additional Summernote dropdown fixes */
        .note-dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            float: left;
            min-width: 160px;
            padding: 5px 0;
            margin: 2px 0 0;
            list-style: none;
            font-size: 14px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 4px;
            -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            background-clip: padding-box;
        }

        .note-dropdown-menu.open {
            display: block;
        }

        .note-dropdown-menu>li>a {
            display: block;
            padding: 3px 20px;
            clear: both;
            font-weight: normal;
            line-height: 1.42857143;
            color: #333;
            white-space: nowrap;
        }

        .note-dropdown-menu>li>a:hover,
        .note-dropdown-menu>li>a:focus {
            color: #262626;
            text-decoration: none;
            background-color: #f5f5f5;
        }

        .note-btn-group.open .note-dropdown-menu {
            display: block;
        }

        .note-btn-group.open .dropdown-toggle {
            outline: 0;
        }

        .note-btn-group.open .dropdown-toggle {
            -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            console.log('=== INDUSTRIES CREATE PAGE ===');
            console.log('jQuery available:', typeof $ !== 'undefined');
            console.log('Summernote available:', typeof $.fn.summernote !== 'undefined');

            if (typeof $.fn.summernote !== 'undefined') {
                console.log('Initializing Summernote...');

                $('#description').summernote({
                    height: 300,
                    tooltip: false,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ],
                    placeholder: 'Write your content here...',
                    tabsize: 2,
                    focus: false,
                    dialogsInBody: true,
                    popover: {
                        image: [
                            ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                            ['float', ['floatLeft', 'floatRight', 'floatNone']],
                            ['remove', ['removeMedia']]
                        ],
                        link: [
                            ['link', ['linkDialogShow', 'unlink']]
                        ],
                        table: [
                            ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                            ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
                        ],
                        air: [
                            ['color', ['color']],
                            ['font', ['bold', 'underline', 'clear']]
                        ]
                    }
                });

                // Fix Summernote dropdowns
                $(document).on('click', '.note-btn-group .dropdown-toggle', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var $this = $(this);
                    var $group = $this.closest('.note-btn-group');
                    var $menu = $group.find('.note-dropdown-menu');

                    // Close other dropdowns
                    $('.note-btn-group').not($group).removeClass('open');
                    $('.note-dropdown-menu').not($menu).removeClass('open').hide();

                    // Toggle current dropdown
                    $group.toggleClass('open');
                    $menu.toggleClass('open').toggle();
                });

                // Close dropdowns when clicking outside
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.note-btn-group').length) {
                        $('.note-btn-group').removeClass('open');
                        $('.note-dropdown-menu').removeClass('open').hide();
                    }
                });

                console.log('Summernote initialized successfully!');
            } else {
                console.error('Summernote is not available!');
            }
        });
    </script>
@endpush
