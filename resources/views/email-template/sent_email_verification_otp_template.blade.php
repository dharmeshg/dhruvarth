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
                <td style="padding: 20px 0; text-align: center; background-color: #ffffff;border-bottom: 1px solid #6A366D;">
                     <a href="{{$business_url}}" target="_blank"><img src="{{$business_logo}}" border="0"></a> 
                </td>
            </tr>
        </table>

        <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 680px; font-family: sans-serif;font-weight: normal;">

            <tr>
                <td bgcolor="#ffffff" style="padding: 15px;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td style="font-size: 14px;color: #555555; padding: 10px; text-align: left;font-family: sans-serif;font-weight: normal;">
                                <p>Hi</p>
                            </td>

                        </tr>
                        <tr>
                            <td style="font-size: 14px;color: #555555; padding: 10px; text-align: left;font-family: sans-serif;font-weight: normal;">
                                <p>You have requested Verification OTP. Please find Your OTP.</p>
                            </td>

                        </tr>
                        <tr>
                            <td style="font-size: 17px;color: #555555; padding: 10px; text-align: left;font-family: sans-serif;font-weight: normal;">
                                <p>{{$randomPassword}}</p>
                            </td>

                        </tr>
                        <tr>
                            <td style="font-size: 14px;color: #555555; padding: 10px; text-align: left;font-family: sans-serif;font-weight: normal;">
                                <p>Do not share this OTP with anyone.</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" bgcolor="#ffffff" style="padding:10px 0;border-top: 1px solid {{Config::get('services.website_constant.THEME_COLOR')}};">
                              
                                    
                                    <br>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" bgcolor="#ffffff" style="padding:10px 0;">
                          
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" bgcolor="#ffffff" style="padding:10px 0;">
                              
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