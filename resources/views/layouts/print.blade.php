<!DOCTYPE html>
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            window.print();
        });
    </script>

    <style type="text/css" media="print">
        @page {
            margin: 2cm 0;
        }

        body {
            margin: 1.6cm;
            font-size: 12px;
        }

        .txt-center {
            text-align: center;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }
    </style>

    @stack('style')

</head>
<body>
<div>
    <div class="brand-section">
            <span style="float: left; margin: -30px 0 0 -30px; width: 50px">
                <img src="{{ asset('assets/global/img/logo.jpg') }}"/>
            </span>
        <div style="text-align: center; margin-top: -30px">
            <h1 class="txt-center">North East Medical College, Sylhet</h1>
        </div>
        <p class="text-right" style="padding:50px 0 0 0"><strong>Generated
                on:</strong> {{\Carbon\Carbon::today()->format('d/m/Y')}}</p>
    </div>
</div>

@yield('content')


</body>
</html>
