$(document).ready(function () {
    var variant_counter = 1;
    $('input[type=radio][name=product_type]').change(function() {
        var checkedValue = $('input[type=radio][name=product_type]:checked').val();
        var first_html = '<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-2 each-attribute"><div class="attribute_div"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="a_metal_purity_0"><label class="custom-control-label" for="a_metal_purity_0">Metal Purity</label></div><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="a_metal_color_0"><label class="custom-control-label" for="a_metal_color_0">Metal Color</label></div><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="a_gender_0"><label class="custom-control-label" for="a_gender_0">Gender</label></div><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="a_status_0"><label class="custom-control-label" for="a_status_0">Status</label></div><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="a_certificate_0"><label class="custom-control-label" for="a_certificate_0">Certificate</label></div><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="a_slu_0"><label class="custom-control-label" for="a_slu_0">Size/Length/Unit</label></div><a href="javascript:;" class="add_variant_btn">Add Variant</a><a href="javascript:;" class="add_more_variant"><i class="fa fa-plus-circle"></i></a></div></div>';
        if(checkedValue == 'variable')
        {
            $('#append_variant_att .main_row').html('');
            $('#append_variant_att .main_row').append(first_html);
        }else{
            $('#append_variant_att .main_row').html('');
        }
    });
    $(document).on("click",".add_variant_btn",function() {
        var eachAttributeDiv = $(this).closest('.each-attribute');
        var checkedValues = [];
        eachAttributeDiv.find('input[type=checkbox]:checked').each(function() {
            checkedValues.push($(this).next('label').text()); // You can use .val() if you prefer the input's value attribute
        });
        if(checkedValues == '')
        {
            alert('Please Select At least one Attribute.');   
        }else{
            $.ajax({
                url: admin_url +"get-variant-html",
                type: "POST",
                data: {
                    checkedValues: checkedValues,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                dataType: 'json',
                success: function(result) {
                    if(result.status == 1)
                    {
                        eachAttributeDiv.append(result.html);
                    }
                }
            }); 
        }
    });
    $(document).on("click",".add_more_variant",function() {
        var html = '<div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 col-xs-12 col-xxl-12 each-attribute mb-2"><div class=attribute_div><div class="custom-checkbox custom-control"><input class=custom-control-input id=a_metal_purity_' + variant_counter +' type=checkbox> <label class=custom-control-label for=a_metal_purity_' + variant_counter +'>Metal Purity</label></div><div class="custom-checkbox custom-control"><input class=custom-control-input id=a_metal_color_' + variant_counter +' type=checkbox> <label class=custom-control-label for=a_metal_color_' + variant_counter +'>Metal Color</label></div><div class="custom-checkbox custom-control"><input class=custom-control-input id=a_gender_' + variant_counter +' type=checkbox> <label class=custom-control-label for=a_gender_' + variant_counter +'>Gender</label></div><div class="custom-checkbox custom-control"><input class=custom-control-input id=a_status_' + variant_counter +' type=checkbox> <label class=custom-control-label for=a_status_' + variant_counter +'>Status</label></div><div class="custom-checkbox custom-control"><input class=custom-control-input id=a_certificate_' + variant_counter +' type=checkbox> <label class=custom-control-label for=a_certificate_' + variant_counter +'>Certificate</label></div><div class="custom-checkbox custom-control"><input class=custom-control-input id=a_slu_' + variant_counter +' type=checkbox> <label class=custom-control-label for=a_slu_' + variant_counter +'>Size/Length/Unit</label></div><a class=add_variant_btn href=javascript:;>Add Variant</a> <a class=remove_appended_variant href=javascript:;><i class="fa fa-minus-circle"></i></a></div></div>';
        $('#append_variant_att .main_row').append(html);
        variant_counter++;
    });
    $(document).on("click",".remove_appended_variant",function() {
        $(this).closest('.each-attribute').remove();
    });
    $(document).on("click",".remove_attr_details",function() {
        $(this).closest('.each-variant-sec').remove();
    });
});