<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body style="background-color:#fff;font-size:12px;color:#333333;margin-top:20px;margin-bottom:20px;margin-right:20px;margin-left:20px;" >
<div class="table-responsive" style="display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar;" >
    <table class="table table-borderless table-top" style="width:100%;margin-bottom:1rem;background-color:#fff;border-collapse:collapse;" >
        <tbody>
        <tr>
            <td colspan="3"
                style="text-align: center; padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;border-width:0;">
                <img src="{{asset('assets/global/img/nemc-logo.png')}}" alt="nemc logo" style="box-sizing:border-box;vertical-align:middle;border-style:none;width:5rem;margin-bottom:5px;" >
                <p style="box-sizing:border-box;margin-top:0;font-size:1.4rem;margin-bottom:0;" >{{Setting::getSiteSetting()->title}}</p>
            </td>
        </tr>
        </tbody>
    </table>
</div>

{!! $body !!}

<div class="table-responsive" style="display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar;" >
    <table class="table table-borderless table-last" style="width:100%;margin-bottom:1rem;background-color:#fff;border-collapse:collapse;" >
        <tbody>
        <tr>
            <td style="padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;border-width:0;" >
                <hr class="footer-separator" style="border-top-width:1px !important;border-top-style:solid !important;border-top-color:rgba(158, 158, 158, 0.23) !important" />
                <div class="text-center text-muted" style="color:#6c757d!important;text-align:center!important;" >
                    <span>{{Setting::getSiteSetting()->phone}}, </span>
                    <span>{{Setting::getSiteSetting()->email}}, </span>
                    <span>{{Setting::getSiteSetting()->adress}}</span>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
