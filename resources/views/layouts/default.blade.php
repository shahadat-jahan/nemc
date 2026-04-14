<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('common.header')
</head>
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

    <div class="m-grid m-grid--hor m-grid--root m-page">

        @include('common.topbar')

        <!-- begin::Body -->
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

                <!-- BEGIN: Left Aside -->
                @include('common.sidebar')

                <div class="m-grid__item m-grid__item--fluid m-wrapper">

                    <div class="m-content">

                        @yield('content')

                    </div>
                </div>
            </div>

            <!-- end:: Body -->

            @include('common.notice_modal')
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

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- end::SweetAlert2 -->

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

        $(document).ready(function() {
            let lastCheckTime = new Date().toISOString();

            function checkForNewNotices() {
                $.get('{{ url('admin/notice_board/check-new-notice') }}', function(data) {
                    if (data.length > 0) {
                        data.forEach(notice => {
                            showDialog(notice.id, notice.message);
                        })
                    }
                });
            }

            function showDialog(id, message) {
                const url = `{{ url('admin/notifications') }}/${id}`;
                const link = `<a class="text-primary" href="${url}">${message}</a>`;
                $('#noticeModal .modal-body').html(link); // Use .html() to insert HTML content
                $('#noticeModal').modal('show');
            }
            // Check for new notices after 10 seconds
            setTimeout(checkForNewNotices, 10000);
        });
    </script>

    @stack('scripts')

    <script>
        $(".m_year_picker").datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            format: "yyyy",
            minViewMode: "years",
            autoclose: true
        });

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


        jQuery.validator.addMethod("noSpace", function(value, element) {
            return value.indexOf(" ") < 0 && value != "";
        }, "No space please and don't leave it empty");

        toastr.options = {
            "closeButton": false,
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

        $('#m_topbar_notification_icon').click(function () {
            let $current = $(this);
           setTimeout(function () {
               let user = '{{Auth::guard('web')->user()->id ?? Auth::guard('student_parent')->user()->id}}';
               let notifications = $current.find('.m-nav__link-badge').length;

               if (notifications != '' || notifications != 0){
                   $.post('{{route('notification.update-status')}}', {user: user, _token: "{{csrf_token()}}"}, function (response) {
                       if (response.status){
                           $current.find('.m-nav__link-badge').remove();
                       }
                   })
               }

           }, 2000);
        });
    </script>

    <script>
        if ( window.history.replaceState ) {
          window.history.replaceState( null, null, window.location.href );
        }
    </script>

</body>
</html>
