<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('common.header')
    <style>
        .notification-detail a:hover {
            text-decoration: none;
        }
    </style>
</head>
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-aside--offcanvas-default">

<div class="m-grid m-grid--hor m-grid--root m-page">

@include('common.topbar-single')

<!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">


        <div class="m-grid__item m-grid__item--fluid m-wrapper">

            <div class="m-content">

                @yield('content')

            </div>
        </div>
    </div>

    <!-- end:: Body -->

    @include('common.footer')

</div>

<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
    <i class="la la-arrow-up"></i>
</div>

<!-- end::Scroll Top -->

<!--begin::Global Theme Bundle -->
<script src="{{asset('assets/global/scripts/vendors.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/scripts/scripts.bundle.js')}}" type="text/javascript"></script>

<script src="{{ asset('assets/global/scripts/custom.js') }}" type="text/javascript"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" type="text/javascript"></script>

<!--end::Global Theme Bundle -->

{{-- <script>
     var DATA_URL = '';
 </script>
 <script src="{{ asset('assets/global/scripts/custom.js') }}" type="text/javascript"></script>

 <script>
     $( document ).ready(function() {
         $('.date-picker').datepicker({
             format: "yyyy-mm-dd"
         });
     });

     $(".select2, .select2-multiple").select2();

 </script>--}}

<script>
    var baseUrl = '{!! url('/') !!}/';
</script>

@stack('scripts')

<script>

    $(".m_selectpicker").selectpicker();

    jQuery.validator.addMethod("email_not_required", function(value, element) {

        if (value.length > 0){
            if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
                return true;
            } else {
                return false;
            }
        }else{
            return true;
        }

    }, "Please enter a valid Email.");

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    @if(Session::has('success'))
        Command: toastr["success"]("{{ Session::get('success') }}", "Success");
    @endif
            @if(Session::has('error'))
        Command: toastr["error"]("{{ Session::get('error') }}", "Error!");
    @endif
</script>

</body>
</html>
