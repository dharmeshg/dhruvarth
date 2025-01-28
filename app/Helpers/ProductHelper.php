<?php

use App\Models\VariantProduct;
use App\Models\Product;
use App\Models\ProductAttribute;

function getProductAttributes($all_attr,$p_product_id,$product_type,$product) 
{
    // dd($all_attr);
    $parent_product = Product::where('id',$p_product_id)->where('visiblity',1)->where(function ($query) {
        $query->where('publish_status', '!=', 'draft')
              ->orWhereNull('publish_status');
    })->first();
    $variants_products = VariantProduct::where('parent_product_id',$p_product_id)->where('visiblity',1)->where(function ($query) {
        $query->where('publish_status', '!=', 'draft')
              ->orWhereNull('publish_status');
    })->get();
    $main_parent_id = $parent_product->id;
    $purities = [];
    $metal_weights = [];
    $metal_colors = [];
    $sizes = [];
    $uniqueSizes = [];
    $uniquegenders = [];
    $uniquemetalweigts = [];
    $uniquemetalpurities = [];
    $uniquemetalcolors = [];
    $uniquediamondclarity = []; 
    $genders = [];
    // metal Purity

    if(isset($all_attr) && in_array('metal_purity',$all_attr))
    {
        if(isset($parent_product->metalpurity->title) && $parent_product->metalpurity->title != null)
        {
            $class = 'parent';
            if(isset($product_type) && $product_type ==  'simple')
            {
                if($parent_product->id == $product->id)
                {
                    $class = 'parent active';
                }
                
            }
            $m_p_Key = $parent_product->metalpurity->title;
            if (!isset($uniquemetalweigts[$m_p_Key])) {
                $uniquemetalpurities[$m_p_Key] = [
                    'p_id' => $parent_product->id,
                    'p_type' => 'parent',
                    'p_metal_purity' => $parent_product->metalpurity->title,
                    'p_purity_id' => $parent_product->p_metal_purity,
                    'p_slug' => $parent_product->p_slug,
                    'class' => $class,
                ];
            }
        }
        if(isset($variants_products) && count($variants_products) > 0)
        {
            foreach($variants_products as $key => $v_product)
            {
                $class = 'variant';
                $this_attr = ProductAttribute::where('id',$v_product->attr_id)->first();
                if(isset($this_attr))
                {
                    $t_check_attr = explode(',',$this_attr->attributes);
                }
                if(isset($all_attr) && !in_array('metal_purity',$t_check_attr))
                {
                    $class .= ' dashed';
                }
                if(isset($product_type) && $product_type ==  'variant')
                {
                    if($v_product->id == $product->id)
                    {
                        $class .= ' active';
                    }
                }
                $m_p_Key = $v_product->metalpurity->title;
                $uniquemetalpurities[$m_p_Key] = [
                    'p_id' => $parent_product->id,
                    'p_type' => 'variant',
                    'p_metal_purity' => $v_product->metalpurity->title,
                    'p_purity_id' => $v_product->p_metal_purity,
                    'p_slug' => $v_product->p_slug,
                    'class' => $class,
                ];
            }
        }
    }

    // Metal Weight

    if(isset($all_attr) && in_array('metal_wieght',$all_attr))
    {
        if(isset($parent_product->p_metal_weigth) && $parent_product->p_metal_weigth != null)
        {
            $class = 'parent';
            if(isset($product_type) && $product_type ==  'simple')
            {
                if($parent_product->id == $product->id)
                {
                    $class = 'parent active';
                }
                
            }
            $m_w_Key = $parent_product->p_metal_weigth . '_' . $parent_product->p_metal_weight_unit;
            if (!isset($uniquemetalweigts[$m_w_Key])) {
                $uniquemetalweigts[$m_w_Key] = [
                    'p_id' => $parent_product->id,
                    'p_type' => 'parent',
                    'p_metal_weight' => $parent_product->p_metal_weigth,
                    'p_metal_unit' => $parent_product->p_metal_weight_unit,
                    'p_slug' => $parent_product->p_slug,
                    'class' => $class,
                ];
            }
        }
        if(isset($variants_products) && count($variants_products) > 0)
        {
            foreach($variants_products as $key => $v_product)
            {
                $class = 'variant';
                $this_attr = ProductAttribute::where('id',$v_product->attr_id)->first();
                if(isset($this_attr))
                {
                    $t_check_attr = explode(',',$this_attr->attributes);
                }
                if(isset($all_attr) && !in_array('metal_wieght',$t_check_attr))
                {
                    $class .= ' dashed';
                }
                if(isset($product_type) && $product_type ==  'variant')
                {
                    if($v_product->id == $product->id)
                    {
                        $class .= ' active';
                    }
                }
                $m_w_Key = $v_product->p_metal_weigth . '_' . $v_product->p_metal_weight_unit;
                if (!isset($uniquemetalweigts[$m_w_Key])) {
                    $uniquemetalweigts[$m_w_Key] = [
                        'p_id' => $parent_product->id,
                        'p_type' => 'variant',
                        'p_metal_weight' => $v_product->p_metal_weigth,
                        'p_metal_unit' => $v_product->p_metal_weight_unit,
                        'p_slug' => $v_product->p_slug,
                        'class' => $class,
                    ];
                }
            }
        }
    }

    // Metal Color
    if(isset($all_attr) && in_array('metal_color',$all_attr))
    {
        if(isset($parent_product->metalcolor->title) && $parent_product->metalcolor->title != null)
        {
            $class = 'parent';
            if(isset($product_type) && $product_type ==  'simple')
            {
                if($parent_product->id == $product->id)
                {
                    $class = 'parent active';
                }
                
            }
            $m_c_Key = $parent_product->metalcolor->title;
            if (!isset($uniquemetalcolors[$m_c_Key])) {
                $uniquemetalcolors[$m_c_Key] = [
                    'p_id' => $parent_product->id,
                    'p_type' => 'parent',
                    'p_metal_color' => $parent_product->metalcolor->title,
                    'p_metal_color_id' => $parent_product->p_metal_color,
                    'p_slug' => $parent_product->p_slug,
                    'class' => $class,
                ];
            }
        }
        if(isset($variants_products) && count($variants_products) > 0)
        {
            foreach($variants_products as $key => $v_product)
            {
                $class = 'variant';
                $this_attr = ProductAttribute::where('id',$v_product->attr_id)->first();
                if(isset($this_attr))
                {
                    $t_check_attr = explode(',',$this_attr->attributes);
                }
                if(isset($all_attr) && !in_array('metal_color',$t_check_attr))
                {
                    $class .= ' dashed';
                }
                if(isset($product_type) && $product_type ==  'variant')
                {
                    if($v_product->id == $product->id)
                    {
                        $class .= ' active';
                    }
                }
                $m_c_Key = $v_product->metalcolor->title;
                if (!isset($uniquemetalcolors[$m_c_Key])) {
                    $uniquemetalcolors[$m_c_Key] = [
                        'p_id' => $parent_product->id,
                        'p_type' => 'variant',
                        'p_metal_color' => $v_product->metalcolor->title,
                        'p_metal_color_id' => $v_product->p_metal_color,
                        'p_slug' => $v_product->p_slug,
                        'class' => $class,
                    ];
                }
            }
        }
    }

    // Sizes

    if (isset($all_attr) && in_array('size', $all_attr)) {
        if (isset($parent_product->p_size) && $parent_product->p_size != null) {
            $class = 'parent';
            if (isset($product_type) && $product_type == 'simple') {
                if ($parent_product->id == $product->id) {
                    $class = 'parent active';
                }
            }
    
            $sizeKey = $parent_product->p_size . '_' . $parent_product->p_unit;
            if (!isset($uniqueSizes[$sizeKey])) {
                $uniqueSizes[$sizeKey] = [
                    'p_id' => $parent_product->id,
                    'p_type' => 'parent',
                    'p_size' => $parent_product->p_size,
                    'p_unit' => $parent_product->p_unit,
                    'p_slug' => $parent_product->p_slug,
                    'class' => $class,
                ];
            }
        }
    
        if (isset($variants_products) && count($variants_products) > 0) {
            foreach ($variants_products as $key => $v_product) {
                $class = 'variant';
                $this_attr = ProductAttribute::where('id', $v_product->attr_id)->first();
                if (isset($this_attr)) {
                    $t_check_attr = explode(',', $this_attr->attributes);
                }
                if (isset($all_attr) && !in_array('size', $t_check_attr)) {
                    $class .= ' dashed';
                }
                if (isset($product_type)) {
                    if ($v_product->id == $product->id) {
                        $class .= ' active';
                    }
                }
    
                $sizeKey = $v_product->p_size . '_' . $v_product->p_unit;
                if (!isset($uniqueSizes[$sizeKey])) {
                    $uniqueSizes[$sizeKey] = [
                        'p_id' => $parent_product->id,
                        'p_type' => 'variant',
                        'p_size' => $v_product->p_size,
                        'p_unit' => $v_product->p_unit,
                        'p_slug' => $v_product->p_slug,
                        'class' => $class,
                    ];
                } else {
                    if ($v_product->id == $product->id) {
                        $uniqueSizes[$sizeKey]['class'] .= ' active';
                    }
                }
            }
        }
    }
    
    // Genders
    if (isset($all_attr) && in_array('gender', $all_attr)) {
        if (isset($parent_product->p_gender) && $parent_product->p_gender != null) {
            $class = 'parent';
            if (isset($product_type) && $product_type == 'simple') {
                if ($parent_product->id == $product->id) {
                    $class = 'parent active';
                }
            }
    
            $genderkey = $parent_product->p_gender;
            if (!isset($uniquegenders[$genderkey])) {
                $uniquegenders[$genderkey] = [
                    'p_id' => $parent_product->id,
                    'p_type' => 'parent',
                    'p_gender' => $parent_product->p_gender,
                    'p_slug' => $parent_product->p_slug,
                    'class' => $class,
                ];
            }
        }
    
        if (isset($variants_products) && count($variants_products) > 0) {
            foreach ($variants_products as $key => $v_product) {
                $class = 'variant';
                $this_attr = ProductAttribute::where('id', $v_product->attr_id)->first();
                if (isset($this_attr)) {
                    $t_check_attr = explode(',', $this_attr->attributes);
                }
                if (isset($all_attr) && !in_array('gender', $t_check_attr)) {
                    $class .= ' dashed';
                }
                if (isset($product_type) && $product_type == 'variant') {
                    if ($v_product->id == $product->id) {
                        $class .= ' active';
                    }
                }
    
                $genderkey = $v_product->p_gender;
                if (!isset($uniquegenders[$genderkey])) {
                    $uniquegenders[$genderkey] = [
                        'p_id' => $parent_product->id,
                        'p_type' => 'variant',
                        'p_gender' => $v_product->p_gender,
                        'p_slug' => $v_product->p_slug,
                        'class' => $class,
                    ];
                } else {
                    if ($v_product->id == $product->id) {
                        $uniquegenders[$genderkey]['class'] .= ' active';
                    }
                }
            }
        }
    }
    // Diamond Clarity
    if(isset($all_attr) && in_array('diamond_clarity',$all_attr))
    {
        if(isset($parent_product->diamond_details) && $parent_product->diamond_details != null && $parent_product->diamond_details != '')
        {
            $diamonds = json_decode($parent_product->diamond_details);
            if(isset($diamonds) && count($diamonds) > 0)
            {
                if(isset($product_type) && $product_type ==  'simple')
                {
                    if($parent_product->id == $product->id)
                    {
                        $class = 'parent active';
                    }
                    
                } 
                foreach($diamonds as $d_key => $diamond)
                {
                    $d_c_Key = $diamond->attr_clarity;
                    if (!isset($uniquediamondclarity[$d_c_Key])) {
                        $uniquediamondclarity[$d_c_Key] = [
                            'p_id' => $parent_product->id,
                            'p_type' => 'parent',
                            'p_diamond_clarity' => $diamond->attr_clarity,
                            'p_slug' => $parent_product->p_slug,
                            'class' => $class,
                        ];
                    }
                }
            }
        }
        if(isset($variants_products) && count($variants_products) > 0)
        {
            foreach($variants_products as $key => $v_product)
            {
                $class = 'variant';
                $this_attr = ProductAttribute::where('id',$v_product->attr_id)->first();
                if(isset($this_attr))
                {
                    $t_check_attr = explode(',',$this_attr->diamond_attributes);
                    foreach ($t_check_attr as $diamond_attr) {
                        $f_t_check_attr[] = 'diamond_' . $diamond_attr;
                    }
                }
                if(isset($all_attr) && !in_array('diamond_clarity',$f_t_check_attr))
                {
                    $class .= ' dashed';
                }
                if(isset($product_type) && $product_type ==  'variant')
                {
                    if($v_product->id == $product->id)
                    {
                        $class .= ' active';
                    }
                }
                if(isset($v_product->diamond_details) && $v_product->diamond_details != null && $v_product->diamond_details != '')
                {
                    $v_diamonds = json_decode($v_product->diamond_details);
                    if(isset($v_diamonds) && count($v_diamonds) > 0)
                    {
                        foreach($v_diamonds as $v_c_key => $v_diamond)
                        {
                            $d_c_Key = $v_diamond->attr_clarity;
                            $uniquediamondclarity[$d_c_Key] = [
                                'p_id' => $parent_product->id,
                                'p_type' => 'variant',
                                'p_diamond_clarity' => $v_diamond->attr_clarity,
                                'p_slug' => $v_product->p_slug,
                                'class' => $class,
                            ];
                        }
                    }
                }
            }
        }
    }
    // Collect unique sizes and genders
    $sizes = array_values($uniqueSizes);
    $genders = array_values($uniquegenders);
    $metal_weights = array_values($uniquemetalweigts);
    $purities = array_values($uniquemetalpurities);
    $metal_colors = array_values($uniquemetalcolors);
    $diamond_clarities = array_values($uniquediamondclarity);
    return compact('purities','metal_weights','metal_colors','sizes','genders','main_parent_id','diamond_clarities');
}
