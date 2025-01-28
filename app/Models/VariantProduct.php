<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Scopes\IsPublicVarinatScope;

class VariantProduct extends Model
{
    use HasFactory, SoftDeletes, Sluggable;
    use Userstamps;
    public $timestamps = true;
    protected $fillable = ['parent_product_id','attr_id','p_category','p_family','p_tags','p_status','p_avail_stock_qty','p_ltd_stock_qty','p_min_order_qty','p_title','p_sku','p_description','p_gender','p_size','p_unit','p_occasion','p_trend','p_measurement','p_measurement_unit','p_qty','p_qty_unit','p_gross_weight','p_gross_weight_unit','p_net_weight','p_n_weight_unit','p_made_in','p_metal_purity','p_metal_rate','p_metal_weigth','p_metal_weight_unit','p_metal_color','p_laboraty','p_certificate_no','p_certificate_link','diamond_details','gemstone_details','pearl_details','p_pricetype','p_fix_price','p_discount','p_pricebreakdown','total_metal_price','total_making_charges','make_dis','dis_making_price','p_total_diamond_charge','diamond_dis','dis_diamond_price','p_total_pearl_charge','pearl_dis','p_dis_pearl_price','p_total_gemstone_charge','gemstone_dis','p_dis_gemstone_price','p_total_other_charge','other_dis','p_dis_other_price','p_grand_price_total','p_payment_g','p_creditcard','p_banktransfer','p_upi','p_cod','p_ccod','p_national_tax','p_above_amount','dCountry','p_hallmarked','p_certified','meta_title','meta_description','p_slug','p_video','p_certificate_file','p_inter_taxes','visiblity','delivery_details','p_popular_gemstone','p_gemstone_shape','p_gemstone_caret','p_gemstone_color','p_gemstone_clarity','p_gemstone_cut','p_gemstone_treatment','p_final_metal_price','p_final_makin_price','p_final_diamond_price','p_final_pearl_price','p_final_gemstone_price','p_final_other_price','p_final_fix_price','fix_dis','p_total_tax_charge','only_making_charges','make_type','p_design','p_brand','p_theme','p_style','db_status','buy_with_confidence_sec','publish_status','file_id','is_public'];
    protected $userstamps = [
       'created_by' => 'created_by', 
       'updated_by' => 'updated_by',
       'deleted_by' => 'deleted_by',
   ];
   protected static function booted()
    {
        static::addGlobalScope(new IsPublicVarinatScope);
    }
   public function category()
    {
        return $this->belongsTo(Category::class, 'p_category');
    }
    public function occasion()
    {
        return $this->belongsTo(Occasion::class, 'p_occasion');
    }
    public function trend()
    {
        return $this->belongsTo(Trend::class, 'p_trend');
    }
    public function style()
    {
        return $this->belongsTo(Style::class, 'p_style');
    }
    public function design()
    {
        return $this->belongsTo(Designe::class, 'p_design');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'p_made_in');
    }
    public function metalpurity()
    {
        return $this->belongsTo(MetalPurity::class, 'p_metal_purity');
    }
    public function metalcolor()
    {
        return $this->belongsTo(Metal::class, 'p_metal_color');
    }
    public function gender()
    {
        return $this->belongsTo(Gender::class, 'p_gender');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'p_unit');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
    public function family()
    {
        return $this->belongsTo(Family::class, 'p_family');
    }
    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function attributes()
    {
        return $this->belongsTo(ProductAttribute::class, 'attr_id');
    }
    public function parent()
    {
        return $this->belongsTo(Product::class, 'parent_product_id');
    }
    public function parentProduct()
    {
        return $this->belongsTo(Product::class, 'parent_product_id');
    }
    public function checkproductimages()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
    public function metal_rate($id)
    {
        $product = VariantProduct::where('id',$id)->first();
        $final_m_rate = 0;
        if(isset($product->p_metal_purity) && $product->p_metal_purity != '' && $product->p_metal_purity != null)
        {
            $metal_rate = MetalRate::where('purity',$product->p_metal_purity)->first();
            if($product->p_metal_weight_unit == 'Grams')
            {
                $final_m_rate = floatval($product->p_metal_weigth) * (isset($metal_rate->rate) ? floatval($metal_rate->rate) : 0); 
            }else{
                $final_m_rate = floatval($product->p_metal_weigth) * 1000 * isset($metal_rate->rate) ? floatval($metal_rate->rate) : 0;
            } 
        }
        return number_format($final_m_rate, 2, '.', ',');
    }
    public function diamond_rate($id)
    {
       $product = VariantProduct::where('id',$id)->first();
       $final_d_rate = 0; 
       $total_amount = 0;
       if(isset($product->diamond_details) && $product->diamond_details != '' && $product->diamond_details != null)
            {
                $diamonds = json_decode($product->diamond_details);
                foreach($diamonds as $diamond)
                {
                    if(isset($diamond->attr_type_dynamic) && $diamond->attr_type_dynamic != '' && $diamond->attr_type_dynamic != null)
                    {
                        $diamond_rate = DiamondRate::where('type',$diamond->attr_type_dynamic)->where('quality',$diamond->attr_type_quality)->first();
                        $final_each_diamond = floatval($diamond_rate->rate) * floatval($diamond->attr_diamond_caret);
                        $final_d_rate += $final_each_diamond;
                    }else{
                        $final_d_rate += isset($diamond->attr_final_diamond_price) ? (floatval($diamond->attr_final_diamond_price)) : 0;
                    }
                }
            }
            if(isset($product->diamond_dis) && $product->diamond_dis == 'percentage' && $product->diamond_dis != null)
            {
                $diamonddiscountAmount = ($product->dis_diamond_price / 100) * $final_d_rate;
                $diamonddiscountedmakingTotal = $final_d_rate - $diamonddiscountAmount;
                $total_amount += $diamonddiscountedmakingTotal;
            }else if(isset($product->diamond_dis) && $product->diamond_dis == 'price'){
                $diamonddiscountedmakingTotal = $final_d_rate - $product->dis_diamond_price;
                $total_amount += $diamonddiscountedmakingTotal;
            }else{
                $total_amount += $final_d_rate;
            }
        return $total_amount;
    }
    public function pearl_rate($id)
    {
        $product = VariantProduct::where('id',$id)->first();
        $final_p_rate = 0; 
        $total_amount = 0;
        
        if(isset($product->pearl_details) && $product->pearl_details != '' && $product->pearl_details != null)
        {
            $pearls = json_decode($product->pearl_details);
            foreach($pearls as $pearl)
            {

                $final_p_rate += isset($pearl->pearl_final_total) ? $pearl->pearl_final_total : 0;
            }  
        }
        if(isset($product->pearl_dis) && $product->pearl_dis == 'percentage' && $product->pearl_dis != null)
        {
            $pearldiscountAmount = ($product->p_dis_pearl_price / 100) * $final_p_rate;
            $pearldiscountedmakingTotal = $final_p_rate - $pearldiscountAmount;
            $total_amount += $pearldiscountedmakingTotal;
        }else if(isset($product->pearl_dis) && $product->pearl_dis == 'price'){
            $pearldiscountedmakingTotal = $final_p_rate - $product->p_dis_pearl_price;
            $total_amount += $pearldiscountedmakingTotal;
        }else{
            $total_amount += $final_p_rate;
        }
        return number_format($total_amount, 2, '.', ',');
    }
    public function gemstone_rate($id)
    {
        $product = VariantProduct::where('id',$id)->first();
        $final_g_rate = 0;
        $total_amount = 0;
        if(isset($product->gemstone_details) && $product->gemstone_details != '' && $product->gemstone_details != null)
        {
            $gemstones = json_decode($product->gemstone_details);
            foreach($gemstones as $gemstone)
            {
                $final_g_rate += isset($gemstone->gemstone_final_total) ? $gemstone->gemstone_final_total : 0;
            }  
        }
        if(isset($product->gemstone_dis) && $product->gemstone_dis == 'percentage' && $product->gemstone_dis != null)
        {
            $gemsdiscountAmount = ($product->p_dis_gemstone_price / 100) * $final_g_rate;
            $gemdiscountedmakingTotal = $final_g_rate - $gemsdiscountAmount;
            $total_amount += $gemdiscountedmakingTotal;
        }else if(isset($product->gemstone_dis) && $product->gemstone_dis == 'price'){
            $gemdiscountedmakingTotal = $final_g_rate - $product->p_dis_gemstone_price;
            $total_amount += $gemdiscountedmakingTotal;
        }else{
            $total_amount += $final_g_rate;
        }
        return number_format($total_amount, 2, '.', ',');
    }
    public function making_rate($id)
    {
        $product = VariantProduct::where('id',$id)->first();
        $metal_rate = $this->metal_rate($id);
        // $diamond_rate = $this->diamond_rate($id);
        // $pearl_rate = $this->pearl_rate($id);
        // $gemstone_rate = $this->gemstone_rate($id); 
        $metal_rate_numeric = (float) str_replace(',', '', $metal_rate);
        // $diamond_rate_numeric = (float) str_replace(',', '', $diamond_rate);
        // $pearl_rate_numeric = (float) str_replace(',', '', $pearl_rate);
        // $gemstone_rate_numeric = (float) str_replace(',', '', $gemstone_rate);
        $diamond_rate_numeric = 0;
        $pearl_rate_numeric = 0;
        $gemstone_rate_numeric = 0;
        $total_amount = $metal_rate_numeric + $diamond_rate_numeric + $pearl_rate_numeric + $gemstone_rate_numeric;
        if(isset($product->make_type) && $product->make_type == 'percentage')
        {
            $mak_amount = $total_amount * ($product->only_making_charges / 100);  
        }else{
            $mak_amount = $product->total_making_charges;
        }
        if(isset($product->make_dis) && $product->make_dis == 'percentage' && $product->make_dis != null)
        {
            $discountAmount = ($product->dis_making_price / 100) * $mak_amount;
            $mak_amount = $mak_amount - $discountAmount;
            
        }else if(isset($product->make_dis) && $product->make_dis == 'price' && $product->make_dis != null){
            $mak_amount = $mak_amount - $product->dis_making_price;
        }else{
            $mak_amount = $mak_amount;
        }
        return number_format($mak_amount, 2, '.', ',');
    }
    public function other_rate($id)
    {
        $product = VariantProduct::where('id',$id)->first();
        $total_amount = 0;
        if(isset($product->p_total_other_charge) && $product->p_total_other_charge != '' && $product->p_total_other_charge != null)
        {
          if(isset($product->other_dis) && $product->other_dis == 'percentage' && $product->other_dis != null)
            {
                $otherdiscountAmount = ($product->p_dis_other_price / 100) * $product->p_total_other_charge;
                $otherdiscountedmakingTotal = $product->p_total_other_charge - $otherdiscountAmount;
                $total_amount += $otherdiscountedmakingTotal;
            }else if(isset($product->other_dis) && $product->other_dis == 'price' && $product->other_dis != null){
                $otherdiscountedmakingTotal = $product->p_total_other_charge - $product->p_dis_other_price;
                $total_amount += $otherdiscountedmakingTotal;
            }else{
                $total_amount += $product->p_total_other_charge;
            }  
        }
        return number_format($total_amount, 2, '.', ',');
    }
    public function tax_rate($id)
    {
        $product = VariantProduct::where('id',$id)->first();
        $tax_amount = 0;
        $metal_rate = 0;
        $diamond_rate = 0;
        $pearl_rate = 0;
        $gemstone_rate = 0;
        $other_rate = 0;
        $making_rate = 0;
        if($product->p_pricetype == 'dynamic')
        {
            $metal_rate = $this->metal_rate($id);
            $diamond_rate = $this->diamond_rate($id);
            $pearl_rate = $this->pearl_rate($id);
            $gemstone_rate = $this->gemstone_rate($id); 
            $other_rate = $this->other_rate($id); 
            $making_rate = $this->making_rate($id);
        }
        
        $metal_rate_numeric = (float) str_replace(',', '', $metal_rate);
        $diamond_rate_numeric = (float) str_replace(',', '', $diamond_rate);
        $pearl_rate_numeric = (float) str_replace(',', '', $pearl_rate);
        $gemstone_rate_numeric = (float) str_replace(',', '', $gemstone_rate);
        $other_rate_numeric = (float) str_replace(',', '', $other_rate);
        $making_rate_numeric = (float) str_replace(',', '', $making_rate);
        if($product->p_pricetype == 'fix_price')
        {
           $total_amount = (float)$product->p_fix_price; 
           
        }else{
           $total_amount = $metal_rate_numeric + $diamond_rate_numeric + $pearl_rate_numeric + $gemstone_rate_numeric + $other_rate_numeric + $making_rate_numeric; 
        } 
        // if(isset($product->db_status) && $product->db_status == 'migrated' && isset($product->p_total_tax_charge) && $product->p_total_tax_charge != null)
        // {
        //     $amts = (float) str_replace(',', '', $product->p_total_tax_charge);
        //     $tax_amount = $total_amount * ($amts / 100);
        // }else{
            if(isset($product->p_national_tax) && $product->p_national_tax != '' && $product->p_national_tax != null && $product->p_national_tax != '0')
            {
                $national_tax = $product->p_national_tax;
                if(isset($product->p_above_amount) && $product->p_above_amount != '' && $product->p_above_amount != null)
                {
                    $above_amount = $product->p_above_amount;
                }else{
                    $above_amount = 0;
                }
            }else{
                $setting = Setting::first();
                $national_tax = (int)$setting->national_tax;
                $above_amount = (int)$setting->nation_above_amount;
            }
            if($total_amount > $above_amount)
            {
                $tax_amount = $total_amount * ($national_tax / 100);
            }
        // }
        return number_format($tax_amount, 2, '.', ',');
    }
    public function total_price($id)
    {

        $product = VariantProduct::where('id',$id)->first();
        $total_amount = 0;
        $tax_amount = 0;
        $final_m_rate = 0;
        $final_d_rate = 0;
        $final_g_rate = 0;
        $final_p_rate = 0;
        if(isset($product->p_national_tax) && $product->p_national_tax != '' && $product->p_national_tax != null && $product->p_national_tax != '0')
        {
            $national_tax = (float)$product->p_national_tax;
            if(isset($product->p_above_amount) && $product->p_above_amount != '' && $product->p_above_amount != null)
            {
                $above_amount = $product->p_above_amount;
            }else{
                $above_amount = 0;
            }
        }else{
            $setting = Setting::first();
            $national_tax = (int)$setting->national_tax;
            $above_amount = (int)$setting->nation_above_amount;
        }
        
        if(isset($product->p_pricetype) && $product->p_pricetype == 'fix_price')
        {
            $fix_price = $product->p_fix_price;
            if($product->fix_dis == 'percentage')
            {
                $discount = ($fix_price * $product->p_discount) / 100;
                $price_after_dis = $fix_price - $discount;
            }else{
                $price_after_dis = $fix_price - $product->p_discount;
            }
            if($price_after_dis > $above_amount)
            {
                $tax_amount = $price_after_dis * ($national_tax / 100);
            }
            $total_amount = $price_after_dis + $tax_amount;
        }else if(isset($product->p_pricetype) && $product->p_pricetype == 'dynamic')
        {
            if(isset($product->p_metal_purity) && $product->p_metal_purity != '' && $product->p_metal_purity != null)
            {
               $metal_rate = MetalRate::where('purity',$product->p_metal_purity)->first();
                if($product->p_metal_weight_unit == 'grams')
                {
                    $final_m_rate = $product->p_metal_weigth * $metal_rate->rate; 
                    $total_amount += $final_m_rate;
                }else{
                    $final_m_rate = $product->p_metal_weigth * 1000 * $metal_rate->rate;
                    $total_amount += $final_m_rate;
                } 
            }
            if(isset($product->diamond_details) && $product->diamond_details != '' && $product->diamond_details != null)
            {
                $diamonds = json_decode($product->diamond_details);
                foreach($diamonds as $diamond)
                {
                    if(isset($diamond) && $diamond != '')
                    {
                        if(isset($diamond->attr_type_dynamic) && $diamond->attr_type_dynamic != '' && $diamond->attr_type_dynamic != null)
                        {
                            $diamond_rate = DiamondRate::where('type',$diamond->attr_type_dynamic)->where('quality',$diamond->attr_type_quality)->first();
                            $final_each_diamond = (float)$diamond_rate->rate * (float)$diamond->attr_diamond_caret;
                            $final_d_rate += $final_each_diamond;
                        }else{
                            $final_d_rate += (int)$diamond->attr_final_diamond_price;
                        }
                    }
                }
            }
            if(isset($product->diamond_dis) && $product->diamond_dis == 'percentage' && $product->diamond_dis != null)
            {
                $diamonddiscountAmount = ($product->dis_diamond_price / 100) * $final_d_rate;
                $diamonddiscountedmakingTotal = $final_d_rate - $diamonddiscountAmount;
                $total_amount += $diamonddiscountedmakingTotal;
            }else if(isset($product->diamond_dis) && $product->diamond_dis == 'price'){
                $diamonddiscountedmakingTotal = $final_d_rate - $product->dis_diamond_price;
                $total_amount += $diamonddiscountedmakingTotal;
            }else{
                $total_amount += $final_d_rate;
            }
            if(isset($product->gemstone_details) && $product->gemstone_details != '' && $product->gemstone_details != null)
            {
                $gemstones = json_decode($product->gemstone_details);
                foreach($gemstones as $gemstone)
                {
                    $final_g_rate += $gemstone->gemstone_final_total;
                }  
            }
            if(isset($product->gemstone_dis) && $product->gemstone_dis == 'percentage' && $product->gemstone_dis != null)
            {
                $gemsdiscountAmount = ($product->p_dis_gemstone_price / 100) * $final_g_rate;
                $gemdiscountedmakingTotal = $final_g_rate - $gemsdiscountAmount;
                $total_amount += $gemdiscountedmakingTotal;
            }else if(isset($product->gemstone_dis) && $product->gemstone_dis == 'price'){
                $gemdiscountedmakingTotal = $final_g_rate - $product->p_dis_gemstone_price;
                $total_amount += $gemdiscountedmakingTotal;
            }else{
                $total_amount += $final_g_rate;
            }
            if(isset($product->pearl_details) && $product->pearl_details != '' && $product->pearl_details != null)
            {
                $pearls = json_decode($product->pearl_details);
                foreach($pearls as $pearl)
                {
                    $final_p_rate += $pearl->pearl_final_total;
                }  
            }
            if(isset($product->pearl_dis) && $product->pearl_dis == 'percentage' && $product->pearl_dis != null)
            {
                $pearldiscountAmount = ($product->p_dis_pearl_price / 100) * $final_p_rate;
                $pearldiscountedmakingTotal = $final_p_rate - $pearldiscountAmount;
                $total_amount += $pearldiscountedmakingTotal;
            }else if(isset($product->pearl_dis) && $product->pearl_dis == 'price'){
                $pearldiscountedmakingTotal = $final_p_rate - $product->p_dis_pearl_price;
                $total_amount += $pearldiscountedmakingTotal;
            }else{
                $total_amount += $final_p_rate;
            }
            // if(isset($product->make_type) && $product->make_type == 'percentage')
            // {
            //     $mak_amount = $total_amount * ($product->only_making_charges / 100);  
            // }else{
            //     $mak_amount = $product->total_making_charges;
            // }
            // if(isset($product->make_dis) && $product->make_dis == 'percentage' && $product->make_dis != null)
            // {
            //     $discountAmount = ($product->dis_making_price / 100) * $mak_amount;
            //     $discountedmakingTotal = $mak_amount - $discountAmount;
            //     $total_amount += $discountedmakingTotal;

            // }else if(isset($product->make_dis) && $product->make_dis == 'price' && $product->make_dis != null){
            //     $discountedmakingTotal = $mak_amount - $product->dis_making_price;
            //     $total_amount += $discountedmakingTotal;
            // }else{
            //     $total_amount += $mak_amount;
            // }
            $making_rate = $this->making_rate($id);
            $making_rate_numeric = (float) str_replace(',', '', $making_rate);
            $total_amount += $making_rate_numeric;

            if(isset($product->p_total_other_charge) && $product->p_total_other_charge != '' && $product->p_total_other_charge != null)
            {
              if(isset($product->other_dis) && $product->other_dis == 'percentage' && $product->other_dis != null)
                {
                    $otherdiscountAmount = ($product->p_dis_other_price / 100) * $product->p_total_other_charge;
                    $otherdiscountedmakingTotal = $product->p_total_other_charge - $otherdiscountAmount;
                    $total_amount += $otherdiscountedmakingTotal;
                }else if(isset($product->other_dis) && $product->other_dis == 'price' && $product->other_dis != null){
                    $otherdiscountedmakingTotal = $product->p_total_other_charge - $product->p_dis_other_price;
                    $total_amount += $otherdiscountedmakingTotal;
                }else{
                    $total_amount += $product->p_total_other_charge;
                }  
            }
            // dd($total_amount);
            if($total_amount > $above_amount)
            {
                $tax_amount = $total_amount * ($national_tax / 100);
            }
            $total_amount += $tax_amount;
        }
        return $total_amount;
    }

    public function discount_metal($id,$total_amount)
    {
        $total_amount = floatval(str_replace(',', '', $total_amount));
        $product = VariantProduct::findOrfail($id);
        $discount = 0;
        if(isset($product->diamond_dis) && $product->diamond_dis != '' && $product->diamond_dis != null)
        {
            $percentage = floatval($product->dis_diamond_price);
            if($product->diamond_dis == 'percentage')
            {
                $discount = ($percentage / 100) * $total_amount;
            }else{
                $discount = $percentage + $total_amount;
            }
        }
        return $discount;
    }
    public function discount_pearl($id,$total_amount)
    {
        $total_amount = floatval(str_replace(',', '', $total_amount));
        $product = VariantProduct::findOrfail($id);
        $discount = 0;
        if(isset($product->pearl_dis) && $product->pearl_dis != '' && $product->pearl_dis != null)
        {
            $percentage = floatval($product->p_dis_pearl_price);
            if($product->pearl_dis == 'percentage')
            {
                $discount = ($percentage / 100) * $total_amount;
            }else{
                $discount = $percentage;
            }
        }
        return $discount;
    }
    public function discount_gem($id,$total_amount)
    {
        $total_amount = floatval(str_replace(',', '', $total_amount));
        $product = VariantProduct::findOrfail($id);
        $discount = 0;
        if(isset($product->gemstone_dis) && $product->gemstone_dis != '' && $product->gemstone_dis != null)
        {
            $percentage = floatval($product->p_dis_gemstone_price);
            if($product->gemstone_dis == 'percentage')
            {
                $discount = ($percentage / 100) * $total_amount;
            }else{
                $discount = $percentage;
            }
        }
        return $discount;
    }
    public function discount_mak($id,$total_amount)
    {
        $total_amount = floatval(str_replace(',', '', $total_amount));
        $product = VariantProduct::findOrfail($id);
        $discount = 0;
        if(isset($product->make_dis) && $product->make_dis != '' && $product->make_dis != null)
        {
            $percentage = floatval($product->dis_making_price);
            if($product->make_dis == 'percentage')
            {
                $discount = ($percentage / 100) * $total_amount;
            }else{
                $discount = $percentage + $total_amount;
            }
        }
        return $discount;
    }
    public function discount_other($id,$total_amount)
    {
       $total_amount = floatval(str_replace(',', '', $total_amount));
        $product = VariantProduct::findOrfail($id);
        $discount = 0;
        if(isset($product->other_dis) && $product->other_dis != '' && $product->other_dis != null)
        {
            $percentage = floatval($product->p_dis_other_price);
            if($product->other_dis == 'percentage')
            {
                $discount = ($percentage / 100) * $total_amount;
            }else{
                $discount = $percentage;
            }
        }
        return $discount; 
    }

    public function overall_discount($id,$grand_amount,$making_total)
    {
        $product = VariantProduct::findOrfail($id);
        $making_total = floatval(str_replace(',', '', $making_total));
        $final_discount_amount = 0;
        $final_m_rate = 0;
        $final_d_rate = 0;
        $final_g_rate = 0;
        $final_p_rate = 0;
        $diamonddiscountAmount = 0;
        $gemsdiscountAmount = 0;
        $pearldiscountAmount = 0;
        $discountAmount = 0;
        $otherdiscountAmount = 0;
        
        
        if(isset($product->p_pricetype) && $product->p_pricetype == 'dynamic')
        {
            if(isset($product->diamond_details) && $product->diamond_details != '' && $product->diamond_details != null)
            {
                $diamonds = json_decode($product->diamond_details);
                foreach($diamonds as $diamond)
                {
                    if(isset($diamond) && $diamond != '')
                    {
                        if(isset($diamond->attr_type_dynamic) && $diamond->attr_type_dynamic != '' && $diamond->attr_type_dynamic != null)
                        {
                            $diamond_rate = DiamondRate::where('type',$diamond->attr_type_dynamic)->where('quality',$diamond->attr_type_quality)->first();
                            $final_each_diamond = (float)$diamond_rate->rate * (float)$diamond->attr_diamond_caret;
                            $final_d_rate += $final_each_diamond;
                        }else{
                            $final_d_rate += (int)$diamond->attr_final_diamond_price;
                        }
                    }
                }
            }
            if(isset($product->diamond_dis) && $product->diamond_dis == 'percentage' && $product->diamond_dis != null)
            {
                $diamonddiscountAmount = ($product->dis_diamond_price / 100) * $final_d_rate;
            }else if(isset($product->diamond_dis) && $product->diamond_dis == 'price'){
                $diamonddiscountAmount = $product->dis_diamond_price;
            }
            

            if(isset($product->gemstone_details) && $product->gemstone_details != '' && $product->gemstone_details != null)
            {
                $gemstones = json_decode($product->gemstone_details);
                foreach($gemstones as $gemstone)
                {
                    $final_g_rate += $gemstone->gemstone_final_total;
                }  
            }
            if(isset($product->gemstone_dis) && $product->gemstone_dis == 'percentage' && $product->gemstone_dis != null)
            {
                $gemsdiscountAmount = ($product->p_dis_gemstone_price / 100) * $final_g_rate;

            }else if(isset($product->gemstone_dis) && $product->gemstone_dis == 'price'){
                $gemsdiscountAmount = $product->p_dis_gemstone_price;
            }
            if(isset($product->pearl_details) && $product->pearl_details != '' && $product->pearl_details != null)
            {
                $pearls = json_decode($product->pearl_details);
                foreach($pearls as $pearl)
                {
                    $final_p_rate += $pearl->pearl_final_total;
                }  
            }
            if(isset($product->pearl_dis) && $product->pearl_dis == 'percentage' && $product->pearl_dis != null)
            {
                $pearldiscountAmount = ($product->p_dis_pearl_price / 100) * $final_p_rate;

            }else if(isset($product->pearl_dis) && $product->pearl_dis == 'price'){
                $pearldiscountAmount = $product->p_dis_pearl_price;
            }
            if(isset($product->make_type) && $product->make_type == 'percentage')
            {
                $mak_amount = $making_total * ($product->only_making_charges / 100);  
            }else{
                $mak_amount = $product->total_making_charges;
            }
            if(isset($product->make_dis) && $product->make_dis == 'percentage' && $product->make_dis != null)
            {
                $discountAmount = ($product->dis_making_price / 100) * $mak_amount;

            }else if(isset($product->make_dis) && $product->make_dis == 'price' && $product->make_dis != null){
                $discountAmount = $product->dis_making_price;
            }
            if(isset($product->p_total_other_charge) && $product->p_total_other_charge != '' && $product->p_total_other_charge != null)
            {
              if(isset($product->other_dis) && $product->other_dis == 'percentage' && $product->other_dis != null)
                {
                    $otherdiscountAmount = ($product->p_dis_other_price / 100) * $product->p_total_other_charge;

                }else if(isset($product->other_dis) && $product->other_dis == 'price' && $product->other_dis != null){
                    $otherdiscountAmount = $product->p_dis_other_price;
                } 
            }
            $final_discount_amount = floatval($diamonddiscountAmount) + floatval($gemsdiscountAmount) + floatval($pearldiscountAmount) + floatval($discountAmount) + floatval($otherdiscountAmount);
        }
        return $final_discount_amount;
    }
   public function sluggable(): array
    {
        return [
            'p_slug' => [
                'source' => 'p_title',
            ]
        ];
    }
}
