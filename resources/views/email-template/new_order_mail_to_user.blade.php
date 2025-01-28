<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>

    <style type="text/css">
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }

        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        a:focus{
            outline: 0;
        }

        div[style*="margin: 16px 0"] {
            margin:0 !important;
        }

        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        table table table {
            table-layout: auto;
        }

        img {
            -ms-interpolation-mode:bicubic;
        }

        .mobile-link--footer a,
        a[x-apple-data-detectors] {
            color:inherit !important;
            text-decoration: underline !important;
        }

    </style>



</head>
<body width="100%" bgcolor="#EEEEEE" style="margin: 0;">
<center style="width: 100%; background: #eeeeee;">

    <div style="max-width: 680px; margin: auto; padding-top: 30px;padding-bottom: 30px;">

        <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 680px; ">
            <tr>
                <td style="padding: 20px 0; text-align: center; background-color: #ffffff;border-bottom: 1px solid var(--theme-orange-red);">
                    <a href="{{$business_url}}" target="_blank"><img src="{{$business_logo}}" border="0"></a>
                </td>
            </tr>
        </table>

        <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 680px; font-family: sans-serif;font-weight: normal;">

            <tr>
                <td bgcolor="#ffffff" style="padding: 15px;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td colspan="3" style="padding:10px 0;">
                                <p style="padding: 0px 20px;font-family: Arial,Helvetica,sans-serif;margin: 0px;font-size: 14px;line-height: normal;color: #666;">
                                    Hi {{$user_details->fullname}},
                                </p>
                            </td>
                        </tr>
            
                        <tr>
                            <td colspan="3" style="padding:10px 0;">
                                <p style="padding: 0px 20px;font-size:14px;line-height: 24px;font-family:Arial, Helvetica, sans-serif;color: #666;margin: 0px;">
                                    Thank you for your order from {{$business_data->business_name}}.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="padding:10px 0;">
                                <p style="padding: 0px 20px;font-size:14px;line-height: 24px;font-family:Arial, Helvetica, sans-serif;color: #666;margin: 0px;">
                                    @if(isset($order_details->comment) && !empty($order_details->comment))
                                    <span><b>Comment</b>: {{$order_details->comment}}</span></span><br>
                                    @endif
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" bgcolor="#ffffff" style="padding:10px 0;border-top: 1px solid var(--theme-orange-red);">
                                <p style="padding: 0px 20px;font-size:14px;line-height: 24px;font-family:Arial, Helvetica, sans-serif;color: #666;margin: 0px;">
                                    If you have any questions, please feel free to contact us at <a href="mailto:{{$admin_email}}" target="_top">{{$admin_email}}</a>@if(!empty($business_data->whatsapp_number)), whatsapp us on <a href="https://wa.me/{{$business_data->whatsapp_number}}" target="_blank">{{$business_data->whatsapp_number}}</a> @endif or visit <a href="{{env('DOMAIN_URL')}}" target="_top">{{env('DOMAIN_URL')}}</a>
                                    
                                    <br>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" bgcolor="#ffffff" style="padding:10px 0;">
                                <p style="padding: 0px 20px;font-size:14px;line-height: 24px;font-family:Arial, Helvetica, sans-serif;color: #666;margin: 0px;">
                                    Copyright {{$business_data->business_name}}  All rights reserved. T&C apply.<br>
                                    
                                         @if (isset($ba_address_line_1) && !empty($ba_address_line_1))
                                             {{$ba_address_line_1}},<br>
                                         @endif
                                         @if (isset($ba_address_line_2) && !empty($ba_address_line_2))
                                             {{$ba_address_line_2}},<br>
                                         @endif
                                         @if (isset($ba_city) && !empty($ba_city))
                                             {{$ba_city}},
                                             @if (isset($ba_state) && !empty($ba_state)){{$ba_state}},@endif
                                             @if (isset($ba_country) && !empty($ba_country)){{$ba_country}}@endif
                                         @endif
                                 <br>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" bgcolor="#ffffff" style="padding:10px 0;">
                                <p style="padding: 0px 20px;font-size:14px;line-height: 24px;font-family:Arial, Helvetica, sans-serif;color: #666;margin: 0px;">
                                    PLEASE DO NOT REPLY DIRECTLY TO THIS E-MAIL - This is an automatically generated email. You are receiving this email because you are a registered customer of {{$business_data->business_name}}.
                                </p>
                            </td>
                        </tr>
                    </table>
                    
                </td>
            </tr>


        </table>
        

    </div>
</center>
</body>
</html>