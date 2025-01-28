<html>
<head>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
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

        img {
            vertical-align: middle;
        }

        .rounded {
            border-radius: .25rem !important;
        }

        .border {
            border: 1px solid #dee2e6 !important;
        }
    </style>
</head>
<body width="100%" bgcolor="#fff" style="margin: 0;">
<center style="width: 100%; background: #eeeeee;">

    <div style="max-width: 100%; margin: auto; padding-bottom: 20px;">


        <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%"
               style="max-width: 100%; font-family: sans-serif;">
            <tr>
                <td style="padding: 10px 0px 40px 0px; text-align: left; background-color: #ffffff;">
                    {{--<a href="{{$business_url}}" target="_blank"><img src="{{$business_logo}}" border="0"></a>--}}
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{$data['bs_logo']}}"
                                 alt="{{$bs->business_name}}" style="padding-left: 15px;"  width="auto" height="50px">
                        </div>
                        <div style="text-align: right; margin-top: -80px; margin-right: 25px;">
                            <span style="margin-right: 43px; font-size: 10px;"><strong>Invoice:</strong> #{{$data['order_details']->id}}</span><br>
                                <span style="font-size: 10px;"><strong>Created:</strong> {{ $data['order_details']->updated_at->format('l, d M Y h:i A') }}
                            </span>
                            <span></span><br>
                            <span></span><br>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                @php
                $country = App\Models\Country::where('id',$bs->country)->first();
                $state = App\Models\State::where('id',$bs->state)->first();
                $city = App\Models\Citie::where('id',$bs->city)->first();
                $shipping_amount = $data['order_details']->check_shipping_amount($data['order_details']->id);
                @endphp
                <td style="font-size: 10px;padding: 0px 0px 20px 0px; text-align: left; background-color: #ffffff;border-bottom: 1px solid var(--theme-orange-red); border-top: 1px solid var(--theme-orange-red);">
                    <div class="row">
                        <div class="col-md-6" style="font-size: 10px;margin-left: 40px; max-width: 50%; width: 50%">
                            <span></span><br>
                            <span style="font-size: 12px;color: #555555;">From:</span><br><br>
                            <span style="font-size: 10px;"><strong>{{$bs->business_name}}</strong></span><br>
                            <span style="font-size: 10px;">{{$city->name}},</span><br>
                            <span style="font-size: 10px;">{{$state->name}}
                                ,{{$country->name}}
                                ,</span><br>
                            <span style="font-size: 10px;">Email: {{$bs->email}}</span><br>
                            <span style="font-size: 10px;">Phone: {{$bs->whatsapp_number}}</span><br>
                            <span></span><br>
                            <span></span><br>
                        </div>
                        <div style="font-size: 10px; text-align: left; margin-left: 72%; margin-top: -140px; margin-right: 50px; width: 50%; max-width: 50%;">
                            <span></span><br>
                            <span style="font-size: 12px;color: #555555; margin-right: 200px;">To:</span><br><br>
                            <span style="font-size: 10px;"><strong>{{$data['user_details']->name}}</strong></span><br>
                            @if(isset($data['user_details']->email) && !empty($data['user_details']->email))
                                <span style="font-size: 10px;">Email: <strong>{{$data['user_details']->email}}</strong></span>
                                <br>
                            @endif
                            <span style="font-size: 10px;">Mobile: <strong>@if(isset($data['user_details']->country_code_number) && !empty($data['user_details']->country_code_number)) {{ $data['user_details']->country_code_number}} @endif @if(isset($data['user_details']->phone) && !empty($data['user_details']->phone)) {{$data['user_details']->phone}} @endif</strong></span><br>
                            <span></span><br>
                            <span></span><br>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="padding: 20px;">
                    <table cellspacing="0" cellpadding="0" width="100%" style=" border-top: 1px solid #eeeeee;">
                        <tbody>
                        <?php
                        $total_weight = 0;
                        $sub_total = 0;
                        $totalGrandPrice = 0;
                        foreach($data['order_items'] as $single_items){
                            if($single_items->product_type == 'simple')
                            {
                                $product = App\Models\Product::where('id',$single_items->product_id)->first();
                            }else{
                                $product = App\Models\VariantProduct::where('id',$single_items->product_id)->first();
                            }
                            if(!$product)
                            {
                                continue;
                            }
                            $p_img = App\Models\ProductImage::where('product_id',$product->id)->where('type',$single_items->product_type)->first();
                            if(isset($p_img) && $p_img != null && $p_img != '')
                            {
                                 if(isset($product->db_status) && $product->db_status != '' && $product->db_status != null && $product->db_status == 'manually')
                                {
                                    $path = asset('product_media/product_images/'.$p_img->name);
                                }else{
                                    $path = asset('uploads/'.$p_img->name);
                                }
                            }else{
                                $path = asset('assets/images/user/img-demo_1041.jpg');
                            }
                            $total_weight += floatval($product->p_metal_weigth);
                            $sub_total += floatval($single_items->total_price);
                            $total_price = str_replace(',', '', $product->total_price($product->id));
                            $total_price_numeric = (float) $total_price;
                            $product_price = $total_price_numeric * floatval($single_items->qty);
                            $totalGrandPrice += $product_price;
                        ?>
                        <tr style="border-top: 1px solid #eeeeee; border-bottom: 1px solid #eeeeee; padding: 10px;">
                            <td width="20%" class="center"
                                style="border-top: 1px solid #eeeeee; text-align: center; padding: 10px; width:20%;"><img
                                        src="{{$path}}" class="img img-fluid border rounded"
                                        height="100px" width="100px"></td>
                            <td width="25%" data-th="Product"
                                style="width:25%; text-align: left; padding: 10px; border-top: 1px solid #eeeeee; font-size: 10px;">
                                <a href="{{route('front.detail.products',[$product->p_slug])}}"
                                   style="font-size: 10px;">{{$product->p_title}} ({{ isset($product->metalpurity->title) ? $product->metalpurity->title : '' }})</a><br>
                                   @if(isset($product->p_metal_weigth) && !empty($product->p_metal_weigth))
                                    <span style="font-size: 10px;">Weight: {{$product->p_metal_weigth}} {{$product->p_metal_weight_unit}}</span>
                                    <br>
                                @else
                                    <span style="font-size: 10px;"></span><br>
                                @endif
                                <span style="font-size: 10px;">SKU:</span> <span
                                        style="font-size: 10px;">{{$product->p_sku}}</span><br>

                                @if(isset($single_pro_offer_price) && !empty($single_pro_offer_price) && $single_pro_offer_price != $single_pro_price)
                                <span style="font-size: 10px;">Price:</span><span
                                        style="font-size: 10px;"> <i class="fa fa-inr" style="vertical-align: bottom;"></i> {{$single_pro_offer_price}}</span> <span
                                        style="text-decoration: line-through; font-size: 10px;">
                                    <i class="fa fa-inr" style="vertical-align: bottom;"></i> {{$single_pro_price}}</span><br>
                                @else
                                    <span style="font-size: 10px;">Price:</span><span
                                            style="font-size: 10px;"></span> <span
                                            style="font-size: 10px;">
                                            <i class="fa fa-inr" style="vertical-align: bottom;"></i> {{$product->total_price($product->id)}}</span><br>
                                @endif
                                @if(isset($data['order_details']?->comment) && !empty($data['order_details']?->comment))
                                    <span style="font-size: 10px;">Note:</span><span
                                        style="font-size: 10px;"> <i class="fa fa-inr" style="vertical-align: bottom;"></i> {{$data['order_details']?->comment}}</span><br>
                                @endif
                                @if(isset($product->p_pricebreakdown) && !empty($product->p_pricebreakdown) && $product->p_pricebreakdown == 'yes' && $product->p_pricetype == 'dynamic')
                                    @if($product->metal_rate($product->id) != '0.00')
                                        <span style="font-size: 10px;">Metal: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
                                                style="font-size: 10px; text-align: right"><i class="fa fa-inr" style="vertical-align: bottom;"></i> &nbsp;{{$product->metal_rate($product->id)}}</span>
                                        <br>
                                    @endif
                                    @if($product->diamond_rate($product->id) != '0.00')
                                    @php
                                        $discounted_diamond_amount = $product->discount_metal($product->id, $product->diamond_rate($product->id));
                                    @endphp
                                        <span style="font-size: 10px;">Diamond: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        @if($discounted_diamond_amount > 0)
                                            <span style="font-size: 10px; text-align: right">
                                                <i class="fa fa-inr" style="vertical-align: bottom;"></i> &nbsp;{{ number_format($product->diamond_rate($product->id), 2, '.', ',') }}
                                        </span> &nbsp;
                                        <span style="font-size: 10px; text-align: right; text-decoration: line-through;">
                                            <i class="fa fa-inr" style="vertical-align: bottom;"></i> &nbsp;{{ number_format($discounted_diamond_amount , 2, '.', ',') }}
                                        </span><br>
                                        @else
                                            <span style="font-size: 10px; text-align: right">
                                                <i class="fa fa-inr" style="vertical-align: bottom;"></i> &nbsp;{{ number_format($product->diamond_rate($product->id), 2, '.', ',') }}
                                        </span><br>
                                        @endif
                                    @endif
                                    @if($product->gemstone_rate($product->id) != '0.00')
                                    @php
                                        $discounted_gem_amount = $product->discount_gem($product->id, $product->gemstone_rate($product->id));
                                    @endphp
                                        <span style="font-size: 10px;">Gemstone: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        @if($discounted_gem_amount > 0)
                                            <span style="font-size: 10px; text-align: right">
                                                <i class="fa fa-inr" style="vertical-align: bottom;"></i> &nbsp;{{ $product->gemstone_rate($product->id) }}
                                        </span> &nbsp;
                                            <span style="font-size: 10px; text-align: right; text-decoration: line-through;">
                                                <i class="fa fa-inr" style="vertical-align: bottom;"></i> &nbsp;{{ number_format($discounted_gem_amount, 2, '.', ',') }}
                                        </span><br>
                                        @else
                                            <span style="font-size: 10px; text-align: right">
                                                <i class="fa fa-inr" style="vertical-align: bottom;"></i> &nbsp;{{ $product->gemstone_rate($product->id) }}
                                        </span><br>
                                        @endif
                                    @endif
                                    @if($product->making_rate($product->id) != '0.00')
                                    @php
                                        $discounted_mak_amount = $product->discount_mak($product->id, $product->making_rate($product->id));
                                    @endphp
                                        <span style="font-size: 10px;">Making: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        @if($discounted_mak_amount > 0)
                                            <span style="font-size: 10px; text-align: right">
                                                <i class="fa fa-inr" style="vertical-align: bottom;"></i> &nbsp;{{ $product->making_rate($product->id) }}
                                        </span> &nbsp;
                                        <span style="font-size: 10px; text-align: right; text-decoration: line-through;">
                                            <i class="fa fa-inr" style="vertical-align: bottom;"></i> &nbsp;{{ number_format($discounted_mak_amount, 2, '.', ',') }}
                                        </span><br>
                                        @else
                                            <span style="font-size: 10px; text-align: right">
                                            <i class="fa fa-inr"
                                               style="padding-top: 10px;"></i>&nbsp;{{ $product->making_rate($product->id) }}
                                        </span><br>
                                        @endif
                                    @endif
                                    @if($product->other_rate($product->id) != '0.00')
                                        <span style="font-size: 10px;">Other Charges: &nbsp;&nbsp;</span>
                                        <span style="font-size: 10px; text-align: right">
                                            <i class="fa fa-inr" style="vertical-align: bottom;"></i> &nbsp;{{ $product->other_rate($product->id) }}
                                        </span><br>
                                    @endif
                                    @if($product->tax_rate($product->id) != '0.00')
                                        <span style="font-size: 10px;">Tax: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        <span style="font-size: 10px; text-align: right">
                                            <i class="fa fa-inr" style="vertical-align: bottom;"></i> &nbsp;{{ $product->tax_rate($product->id) }}
                                        </span><br>
                                    @endif
                                @endif
                            </td>
                            <td width="10%"
                                style="width:10%; font-size: 10px; border-top: 1px solid #eeeeee; text-align: center; padding: 10px;">
                                Qty: {{$single_items->qty}}</td>
                            <td width="15%"
                                style="width:25%; font-size: 10px; border-top: 1px solid #eeeeee; text-align: right; padding: 10px;">
                                @if(isset($product->p_metal_weight_unit) && !empty($product->p_metal_weight_unit))
                                    <?php
                                    $total_item_weight = $single_items->no_of_product * $single_items->Metal_Weight;
                                    ?>
                                    <span style="font-size: 10px;">Weight: {{$product->p_metal_weigth}} {{$product->p_metal_weight_unit}}</span>
                                @else
                                    <span style="font-size: 10px;"></span>
                                @endif
                            </td>
                            @if($data['order_items']->contains('promo_code_id', '!=', null))
                            <td width="20%"
                                style="width:25%; font-size: 10px; border-top: 1px solid #eeeeee; padding-top: 10px;text-align: right;padding-right: 5px; padding-left: 10px;padding-bottom: 10px;">
                                @if(isset($single_items->promo_code_discount) && $single_items->promo_code_discount != null)
                                    <span style="font-size: 10px;">Code Discount: </span> <span style="font-size: 10px;"><i class="fa fa-inr" style="vertical-align: bottom;"></i> {{$single_items->promo_code_discount}}</span>
                                @endif
                            </td>
                            @else
                            <td>&nbsp;</td>
                            @endif
                            <td width="10%"
                                style="width:25%; font-size: 10px; border-top: 1px solid #eeeeee; padding-top: 10px;text-align: right;padding-right: 5px; padding-left: 10px;padding-bottom: 10px;">
                                <?php

                                if(isset($single_items->promo_code_discount) && $single_items->promo_code_discount != null)
                                {
                                    $total_price = ($single_items->qty * $single_items->total_price) - $single_items->promo_code_discount;
                                }else{
                                    $total_price = $single_items->qty * $single_items->total_price;
                                }
                                ?>
                                <span style="font-size: 10px;">Price: </span> <span style="font-size: 10px;"><i class="fa fa-inr" style="vertical-align: bottom;"></i> {{number_format($total_price,2)}}</span>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr class="border-bottom">
                            <td class="small-caps table-bg" colspan="5"
                                style="font-size: 10px; text-align: right;padding: 10px;border-top: 1px solid #eeeeee;">
                                Total Weight:
                            </td>
                            <td class="table-bg"
                                style="font-size: 10px; text-align: right; padding-right: 5px; padding-left:31px; border-top: 1px solid #eeeeee;margin-top: 5px;">
                                @if(isset($total_weight) && !empty($total_weight))
                                    {{$total_weight}}
                                    grams
                                @endif
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="small-caps table-bg" colspan="5"
                                style="font-size: 10px; text-align: right;padding: 10px;border-top: 1px solid #eeeeee;">
                                Sub Total:
                            </td>
                            <td class="table-bg"
                                style="font-size: 10px; text-align: right; padding-right: 5px; padding-left:31px; border-top: 1px solid #eeeeee;margin-top: 5px;">

                                @if(isset($totalGrandPrice) && !empty($totalGrandPrice))
                                    {{ number_format($totalGrandPrice, 2) }}
                                @endif
                            </td>
                        </tr>
                        @php
                        $promo_code_dicount = 0;
                        @endphp
                        @if (isset($data['order_details']->promo_code_discount) && !empty($data['order_details']->promo_code_discount))
                        @php
                            $promo_code_dicount = $data['order_details']->promo_code_discount;
                        @endphp
                        <tr class="border-bottom">
                            <td class="small-caps table-bg" colspan="5"
                                style="font-size: 10px; text-align: right;padding: 10px;border-top: 1px solid #eeeeee;">
                                Your Saving:
                            </td>
                            <td class="table-bg"
                                style="font-size: 10px; text-align: right; border-top: 1px solid #eeeeee;margin-top: 5px;">
                                <i class="fa fa-inr" style="vertical-align: bottom;"></i> - {{ number_format($promo_code_dicount, 2) }}
                            </td>
                        </tr>
                        @endif
                        <tr class="border-bottom">
                            <td class="small-caps table-bg" colspan="5"
                                style="font-size: 10px; text-align: right;padding: 10px;border-top: 1px solid #eeeeee;">
                                Shipping Rate:
                            </td>
                            <td class="table-bg"
                                style="font-size: 10px; text-align: right; border-top: 1px solid #eeeeee;margin-top: 5px;">
                                <i class="fa fa-inr" style="vertical-align: bottom;"></i> + {{ number_format($shipping_amount, 2) }}
                            </td>
                        </tr>

                        <tr class="border-bottom">
                            <td class="small-caps table-bg" colspan="5"
                                style="font-size: 10px; text-align: right; padding: 10px; border-top: 1px solid #eeeeee;">
                                Total Price:
                            </td>
                            <td class="table-bg" style="font-size: 10px; text-align: right; border-top: 1px solid #eeeeee;"><i class="fa fa-inr" style="vertical-align: bottom;"></i> {{ number_format(($totalGrandPrice + $shipping_amount) - $promo_code_dicount , 2) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</center>
</body>
</html>
