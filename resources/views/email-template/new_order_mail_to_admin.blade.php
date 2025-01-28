<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

        a:focus {
            outline: 0;
        }

        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        table {
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        table table table {
            table-layout: auto;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        .mobile-link--footer a,
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: underline !important;
        }

        th {
            background-color: #dcdcdc;
        }

        .col-md-6 {
            width: 50%;
        }

        .row {
            width: 100%;
        }

        a:hover {
            color: #0000ff;
        }

        a {
            color: #000000;
            text-decoration: none;
        }
        td{
            width: 100%;
        }
    </style>
</head>
<body width="100%" bgcolor="#eeeeee" style="margin: 0;">
<center style="width: 100%; background: #eeeeee;">

    <div style="max-width: 680px; margin: auto; padding-top: 30px;padding-bottom: 30px;">


        <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%"
               style="max-width: 680px; font-family: sans-serif;">
            <tr>
                <td style="padding: 20px 0; text-align: left; background-color: #ffffff;border-bottom: 1px solid var(--theme-orange-red);">
                    {{--<a href="{{$business_url}}" target="_blank"><img src="{{$business_logo}}" border="0"></a>--}}
                    <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%"
                           style="max-width: 680px; font-family: sans-serif;">
                        <tr>
                            <td>
                                <a href="{{$business_url}}" target="_blank"><img src="{{$business_logo}}" border="0"
                                                                                 style="margin-left: 25px"></a>
                            </td>
                            <td>
                                <div class="biz-details" style="text-align: right; margin-right: 25px;">
                                    <span>{{$business_data->business_name}}</span><br>
                                    <span>{{$business_data->street}}</span><br>
                                    <span>{{$business_data->area}}</span><br>
                                    <span> {{$ba_city}},{{$ba_state}},</span><br>
                                    <span>{{$ba_country}},{{$business_data->pincode}}.</span><br>
                                    <span>Email:{{$business_data->email}}</span><br>
                                    <span>mobile: {{$business_data->    whatsapp_number}}</span><br>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="font-size: 14px;color: #555555; padding: 15px">
                    Hi {{$business_data->business_name}},
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="font-size: 14px;color: #555555; padding: 0px 15px 15px 15px;">
                    Congratulations, You have new order from {{$user_details->fullname}}. The Order is as
                    follows:
                </td>
            </tr>
            <tr>
                <td style="padding: 20px 0; text-align: left; background-color: #ffffff;border-bottom: 1px solid var(--theme-orange-red);">
                    <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%"
                           style="max-width: 680px; font-family: sans-serif;">
                        <tr>
                            <td>
                                <div style="margin-left: 25px; border-right: 1px solid var(--theme-orange-red);">
                                    <span style="font-size: 20px;color: #555555;"><b> Order Summary</b></span><br><br>
                                    <span></span>
                                    <span><b>Order #</b>: {{$order_details->id}}</span><br>
                                    <span><b>Order
                                            date</b>: <?php echo \Carbon\Carbon::now()->setTimezone('Asia/Kolkata')->format('l, d M Y h:i A');?></span><br>
                                   @if(isset($order_details->comment) && !empty($order_details->comment))
                                            <span><b>Comment</b>: {{$order_details->comment}}</span></span><br>
                                   @endif         
                                </div>
                            </td>
                            <td>
                                <div style="text-align: right; margin-right: 25px;">
                                    <span style="font-size: 20px;color: #555555;"><b> Customer
                                            Details</b></span><br><br>
                                    <span>{{$user_details->fullname}}</span><br>
                                    <span>Email:{{$user_details->email}}</span><br>
                                    <span>Mobile:{{isset($user_details->mobile) ? $user_details->mobile ? ''}}</span><br>
                                    <span></span><br>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="padding: 20px;">
                    <table cellspacing="0" cellpadding="0" width="100%" style=" border: 1px solid #eeeeee;">
                        <thead style="border: 1px solid #eeeeee">
                        <tr style="border: 1px solid #eeeeee">
                            <th class="center" style="border: 1px solid #eeeeee" width="5%">Sr No</th>
                            <th style="border: 1px solid #eeeeee" width="25%">Product</th>
                            <th style="border: 1px solid #eeeeee" width="5%">Qty</th>
                            <th style="border: 1px solid #eeeeee" width="10%">Product Weight</th>
                            <th class="right" style="border: 1px solid #eeeeee" width="15%">Price</th>
                            <th class="right" style="border: 1px solid #eeeeee" width="15%">Total</th>
                            <th class="right" style="border: 1px solid #eeeeee" width="15%">Total Weight</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        $total_weight = 0;
                        $item_weight = 0;
                        $price = 0;
                        $totalGrandPrice = 0;

                        foreach($order_items as $single_items){

                            $product = App\Models\Product::where('id',$single_items->product_id)->first();
                                            
                        if (isset($product->p_metal_weigth) && !empty($product->p_metal_weigth)) {
                            $weight = $product->p_metal_weigth;
                            $item_weight = $weight * $single_items->qty;
                            $total_weight = $total_weight + $item_weight;
                        } else {
                            $item_weight = $item_weight;
                            $total_weight = $total_weight;
                            $price = $price;

                        }
                        $product_price = $product->p_grand_price_total * $single_items_w->qty;
                        $totalGrandPrice += $product_price;

                        ?>
                        <tr style="border: 1px solid #eeeeee; padding: 10px;">
                            <td class="center"
                                style="text-align: center;border: 1px solid #eeeeee; padding: 10px;">{{$i}}</td>
                            <td data-th="Product"
                                style="text-align: left;border: 1px solid #eeeeee; padding: 10px;">
                                {{$product->p_title}} <br>
                                <b>Note : </b> 
                            </td>
                            <td style="text-align: center; border: 1px solid #eeeeee;padding: 10px;">{{$single_items->qty}}</td>
                            <td style="text-align: center; border: 1px solid #eeeeee;padding: 10px;">
                                @if(isset($product->p_metal_weigth) && !empty($product->p_metal_weigth))
                                    {{$product->p_metal_weigth}} grams
                                @endif
                            </td>
                            <td style="text-align: right; border: 1px solid #eeeeee;padding: 10px;"><i
                                        class="fa fa-inr"
                                        style="margin-top: 5px"></i>
                                {{number_format($single_items->total_price)}}</td>
                            <td style="text-align: right;border: 1px solid #eeeeee;padding-top: 10px;padding-right: 5px; padding-left: 10px;padding-bottom: 10px;">
                                <i class="fa fa-inr"
                                   style="margin-top: 5px;"></i>
                                {{number_format($single_items->qty * $single_items->total_price,2)}}
                            </td>
                            <td style="text-align: right; border: 1px solid #eeeeee;padding: 10px;">
                                @if(isset($item_weight) && !empty($item_weight))
                                    {{$item_weight,2}} grams
                                @endif
                            </td>
                        </tr>
                        <?php
                        $i++;
                        }
                        ?>
                        <tr class="border-bottom">
                            <td class="small-caps table-bg" colspan="6"
                                style="text-align: right;padding: 10px;border-top: 1px solid #eeeeee;">Total Weight:
                            </td>
                            <td class="table-bg"
                                style="text-align: right; padding-right: 5px; padding-left:31px; border-top: 1px solid #eeeeee;margin-top: 5px;">
                                @if(isset($total_weight) && !empty($total_weight)){{number_format($total_weight,2)}}
                                grams
                                @endif
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="small-caps table-bg" colspan="6"
                                style="text-align: right; padding: 10px; border-top: 1px solid #eeeeee;">Subtotal:
                            </td>
                            <td class="table-bg"
                                style="text-align: right; padding-right: 5px;padding-left:10px;border-top: 1px solid #eeeeee;margin-top: 5px;">
                                <i class="fa fa-inr"
                                   style="margin-top: 5px;"></i>{{number_format($totalGrandPrice,2)}}</td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="small-caps table-bg" colspan="6"
                                style="text-align: right; padding: 10px; border-top: 1px solid #eeeeee;">Shipping Rate:
                            </td>
                            <td class="table-bg"
                                style="text-align: right; padding-right: 5px;padding-left:10px;border-top: 1px solid #eeeeee;margin-top: 5px;">
                                <i class="fa fa-inr"
                                   style="margin-top: 5px;"></i>{{number_format(0,2)}}</td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="small-caps table-bg" colspan="6"
                                style="text-align: right; padding: 10px; border-top: 1px solid #eeeeee;">Total Price:
                            </td>
                            <td class="table-bg"
                                style="text-align: right; padding-right: 5px;padding-left:10px;border-top: 1px solid #eeeeee;margin-top: 5px;">
                                <i class="fa fa-inr"
                                   style="margin-top: 5px;"></i>{{number_format($totalGrandPrice,2)}}</td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" bgcolor="#ffffff" style="padding:10px 0;border-top: 1px solid var(--theme-orange-red);">
                    <p style="padding: 0px 20px;font-size:14px;line-height: 24px;font-family:Arial, Helvetica, sans-serif;color: #666;margin: 0px;">
                        If you have any questions, please feel free to contact us at <a href="mailto:{{$admin_email}}" target="_top">{{$admin_email}}</a>@if(!empty($business_data->    whatsapp_number)), whatsapp us on <a href="https://wa.me/{{$business_data->  whatsapp_number}}" target="_blank">{{$business_data->  whatsapp_number}}</a> @endif or visit <a href="{{env('APP_URL')}}" target="_top">{{env('APP_URL')}}</a>
                        
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


    </div>
</center>
</body>
</html>
