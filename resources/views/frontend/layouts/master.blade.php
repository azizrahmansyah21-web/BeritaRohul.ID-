<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @hasSection('title')
            @yield('title')
        @else
            {{ $settings['site_seo_title'] }}
        @endif
    </title>

    <meta name="description" content="@hasSection('meta_description') @yield('meta_description') @else {{ $settings['site_seo_description'] }} @endif">
    <meta name="keywords" content="{{ $settings['site_seo_keywords'] }}">

    <meta property="og:title" content="@yield('meta_og_title')">
    <meta property="og:description" content="@yield('meta_og_description')">
    <meta property="og:image" content="@hasSection('meta_og_image') @yield('meta_og_image') @else {{ asset($settings['site_logo']) }} @endif">

    <meta name="twitter:title" content="@yield('meta_tw_title')">
    <meta name="twitter:description" content="@yield('meta_tw_description')">
    <meta name="twitter:image" content="@yield('meta_tw_image')">

    <link rel="icon" href="{{ asset($settings['site_favicon']) }}" type="image/png">

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap-iconpicker.min.css') }}">

    @php
        $siteColor = $settings['site_color'] ?? '#267538';
    @endphp

    <style>
        :root {
            --colorPrimary: {!! $siteColor !!};
        }

        .wp-block-button__link {
            color: #fff;
            background-color: #32373c;
            border-radius: 9999px;
            box-shadow: none;
            text-decoration: none;
            padding: calc(.667em + 2px) calc(1.333em + 2px);
            font-size: 1.125em;
        }

        .wp-block-file__button {
            background: #32373c;
            color: #fff;
            text-decoration: none;
        }
    </style>

    @stack('styles')
</head>

<body>

@php
    $socialLinks = \App\Models\SocialLink::where('status', 1)->get();
    $footerInfo = \App\Models\FooterInfo::where('language', getLangauge())->first();
    $footerGridOne = \App\Models\FooterGridOne::where(['status' => 1, 'language' => getLangauge()])->get();
    $footerGridTwo = \App\Models\FooterGridTwo::where(['status' => 1, 'language' => getLangauge()])->get();
    $footerGridThree = \App\Models\FooterGridThree::where(['status' => 1, 'language' => getLangauge()])->get();
    $footerGridOneTitle = \App\Models\FooterTitle::where(['key' => 'grid_one_title', 'language' => getLangauge()])->first();
    $footerGridTwoTitle = \App\Models\FooterTitle::where(['key' => 'grid_two_title', 'language' => getLangauge()])->first();
    $footerGridThreeTitle = \App\Models\FooterTitle::where(['key' => 'grid_three_title', 'language' => getLangauge()])->first();
@endphp

@include('frontend.layouts.header')

@yield('content')

@include('frontend.layouts.footer')

<a href="javascript:" id="return-to-top">
    <i class="fa fa-chevron-up"></i>
</a>

<script src="{{ asset('frontend/assets/js/index.bundle.js') }}"></script>
@include('sweetalert::alert')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('admin/assets/js/bootstrap-iconpicker.bundle.min.js') }}"></script>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: function(toast) {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        $('#site-language').on('change', function() {
            let languageCode = $(this).val();

            $.ajax({
                method: 'GET',
                url: "{{ route('language') }}",
                data: {
                    language_code: languageCode
                },
                success: function(data) {
                    if (data.status === 'success') {
                        window.location.href = "{{ url('/') }}";
                    }
                },
                error: function(data) {
                    console.error(data);
                }
            });
        });

        $('.newsletter-form').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                method: 'POST',
                url: "{{ route('subscribe-newsletter') }}",
                data: $(this).serialize(),
                beforeSend: function() {
                    $('.newsletter-button').text('loading...');
                    $('.newsletter-button').attr('disabled', true);
                },
                success: function(data) {
                    if (data.status === 'success') {
                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        });

                        $('.newsletter-form')[0].reset();
                        $('.newsletter-button').text('sign up');
                        $('.newsletter-button').attr('disabled', false);
                    }
                },
                error: function(data) {
                    $('.newsletter-button').text('sign up');
                    $('.newsletter-button').attr('disabled', false);

                    if (data.status === 422) {
                        let errors = data.responseJSON.errors;

                        $.each(errors, function(index, value) {
                            Toast.fire({
                                icon: 'error',
                                title: value[0]
                            });
                        });
                    }
                }
            });
        });
    });
</script>

@stack('scripts')

</body>
</html>