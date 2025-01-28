<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ProductImportFile;
use App\Models\Product;
use App\Models\Family;
use App\Models\Occasion;
use App\Models\Trend;
use App\Models\Designe;
use App\Models\Style;
use App\Models\Country;
use App\Models\Brand;
use App\Models\Theme;
use App\Models\Gender;
use App\Models\Unit;
use App\Models\QUnit;
use App\Models\WUnit;
use App\Models\MetalPurity;
use App\Models\Metal;
use App\Models\Laboratory;
use App\Models\DynamicDiamondType;
use App\Models\DiamondRate;
use App\Models\ProductNature;
use App\Models\ProductFancyColor;
use App\Models\ProductColor;
use App\Models\ProductShape;
use App\Models\ProductClarity;
use App\Models\ProductCut;
use App\Models\ProductSetting;
use App\Models\ProductPearl;
use App\Models\ProductGrade;
use App\Models\ProductGemstone;
use App\Models\PopularGemstone;
use App\Models\GemstoneTreatment;
use Illuminate\Support\Str;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Log;

class BulkGemstoneImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $import_id;
    public function __construct($import_id)
    {
        $this->import_id = $import_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $file = ProductImportFile::findOrfail($this->import_id);
        $cat_id = $file->category;
        $filePath = storage_path('app/public/files/product_imported_files/' . $file->file_name);
        if (!file_exists($filePath)) {
            // Handle the case where the file does not exist
            return;
        }
        // diamond attributes
        $diamond_nature = ProductNature::where('type', 'diamond')->pluck('title')->toArray();
        $diamond_fancy_color = ProductFancyColor::where('type', 'diamond')->pluck('title')->toArray();
        $diamond_color = ProductColor::where('type', 'diamond')->pluck('title')->toArray();
        $diamond_shape = ProductShape::where('type', 'diamond')->pluck('title')->toArray();
        $diamond_clarity = ProductClarity::where('type', 'diamond')->pluck('title')->toArray();
        $diamond_cut = ProductCut::where('type', 'diamond')->pluck('title')->toArray();
        $diamond_setting = ProductSetting::where('type', 'diamond')->pluck('title')->toArray();

        // Pearl Attributes
        $pearl_nature = ProductNature::where('type', 'pearl')->pluck('title')->toArray();
        $pearl_color = ProductColor::where('type', 'pearl')->pluck('title')->toArray();
        $pearl_shape = ProductShape::where('type', 'pearl')->pluck('title')->toArray();
        $pearl_setting = ProductSetting::where('type', 'pearl')->pluck('title')->toArray();
        $pearl_pearl = ProductPearl::where('type', 'pearl')->pluck('title')->toArray();
        $pearl_grade = ProductGrade::where('type', 'pearl')->pluck('title')->toArray();

        // Gemstone Attributes
        $gem_nature = ProductNature::where('type', 'gemstone')->pluck('title')->toArray();
        $gem_color = ProductColor::where('type', 'gemstone')->pluck('title')->toArray();
        $gem_shape = ProductShape::where('type', 'gemstone')->pluck('title')->toArray();
        $gem_setting = ProductSetting::where('type', 'gemstone')->pluck('title')->toArray();
        $gem_gemstone = ProductGemstone::where('type', 'gemstone')->pluck('title')->toArray();
        $gem_clarity = ProductClarity::where('type', 'gemstone')->pluck('title')->toArray();
        $gem_cut = ProductCut::where('type', 'gemstone')->pluck('title')->toArray();

        // dd($diamond_nature);
        $fileContents = file_get_contents($filePath);
        $rows = array_map('str_getcsv', file($filePath));
        $rows = array_slice($rows, 1);
        $invalid_count = 0;
        $updated_count = 0;
        $completed_count = 0;
        $invalid_data = [];
        $updated_data = [];
        $completed_data = [];
        foreach ($rows as $r_key => $row) {
            foreach ($row as &$value) {
                $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            }
            $diamond_data = [];
            $pearl_data = [];
            $gemstone_data = [];
            $sku = isset($row[1]) && $row[1] != '' ? trim($row[1]) : null;
            $family = isset($row[2]) && $row[2] != '' ? $row[2] : null;
            $tags = isset($row[3]) && $row[3] != '' ? $row[3] : null;
            $slug = isset($row[4]) && $row[4] != '' ? $row[4] : null;
            $status = isset($row[5]) && $row[5] != '' ? $row[5] : null;
            $avail_stock_qty =  isset($row[6]) && $row[6] != '' ? $row[6] : null;
            $indicate_stock_qty = isset($row[7]) && $row[7] != '' ? $row[7] : null;
            $minimum_stock_qty = isset($row[8]) && $row[8] != '' ? $row[8] : null;
            $title = isset($row[9]) && $row[9] != '' ? $row[9] : null;
            $description = isset($row[10]) && $row[10] != '' ? $row[10] : null;
            $gender = isset($row[11]) && $row[11] != '' ? $row[11] : null;
            $size = isset($row[12]) && $row[12] != '' ? $row[12] : null;
            $unit = isset($row[13]) && $row[13] != '' ? $row[13] : null;
            $occassion = isset($row[14]) && $row[14] != '' ? $row[14] : null;
            $trend = isset($row[15]) && $row[15] != '' ? $row[15] : null;
            $design = isset($row[16]) && $row[16] != '' ? $row[16] : null;
            $style = isset($row[17]) && $row[17] != '' ? $row[17] : null;
            $brand = isset($row[18]) && $row[18] != '' ? $row[18] : null;
            $theme = isset($row[19]) && $row[19] != '' ? $row[19] : null;
            $measurements = isset($row[20]) && $row[20] != '' ? $row[20] : null;
            $measurements_unit = isset($row[21]) && $row[21] != '' ? $row[21] : null;
            $quantity = isset($row[22]) && $row[22] != '' ? $row[22] : null;
            $quantity_unit = isset($row[23]) && $row[23] != '' ? $row[23] : null;
            $gross_weight = isset($row[24]) && $row[24] != '' ? $row[24] : null;
            $gross_weight_unit = isset($row[25]) && $row[25] != '' ? $row[25] : null;
            $net_weight = isset($row[26]) && $row[26] != '' ? $row[26] : null;
            $net_weight_unit = isset($row[27]) && $row[27] != '' ? $row[27] : null;
            $made_in = isset($row[28]) && $row[28] != '' ? $row[28] : null;
            $popular_gemstone = isset($row[29]) && $row[29] != '' ? $row[29] : null;
            $final_shape = isset($row[30]) && $row[30] != '' ? $row[30] : null;
            $final_carat = isset($row[31]) && $row[31] != '' ? $row[31] : null;
            $final_color = isset($row[32]) && $row[32] != '' ? $row[32] : null;
            $final_clarity = isset($row[33]) && $row[33] != '' ? $row[33] : null;
            $final_cut = isset($row[34]) && $row[34] != '' ? $row[34] : null;
            $final_treatment = isset($row[35]) && $row[35] != '' ? $row[35] : null;
            $laboratory = isset($row[36]) && $row[36] != '' ? $row[36] : null;
            $certificate_no = isset($row[37]) && $row[37] != '' ? $row[37] : null;
            $certificate_link = isset($row[38]) && $row[38] != '' ? $row[38] : null;
            $visiblity = isset($row[39]) && $row[39] != '' ? $row[39] : null;
            $draft = isset($row[40]) && $row[40] != '' ? $row[40] : null;
            $price_type = isset($row[41]) && $row[41] != '' ? $row[41] : null;
            $diamond_data['nature'] = isset($row[42]) && $row[42] != '' ? $row[42] : null;
            $diamond_data['fancy_color'] = isset($row[43]) && $row[43] != '' ? $row[43] : null;
            $diamond_data['color'] = isset($row[44]) && $row[44] != '' ? $row[44] : null;
            $diamond_data['carat'] = isset($row[45]) && $row[45] != '' ? $row[45] : null;
            $diamond_data['shape'] = isset($row[46]) && $row[46] != '' ? $row[46] : null;
            $diamond_data['clarity'] = isset($row[47]) && $row[47] != '' ? $row[47] : null;
            $diamond_data['cut'] = isset($row[48]) && $row[48] != '' ? $row[48] : null;
            $diamond_data['setting'] = isset($row[49]) && $row[49] != '' ? $row[49] : null; 
            $diamond_data['total_count'] = isset($row[50]) && $row[50] != '' ? $row[50] : null; 
            $diamond_data['price_per_carat'] = isset($row[51]) && $row[51] != '' ? $row[51] : null; 
            $pearl_data['nature'] = isset($row[52]) && $row[52] != '' ? $row[52] : null;
            $pearl_data['color'] = isset($row[53]) && $row[53] != '' ? $row[53] : null;
            $pearl_data['carat'] = isset($row[54]) && $row[54] != '' ? $row[54] : null;
            $pearl_data['pearl'] = isset($row[55]) && $row[55] != '' ? $row[55] : null;
            $pearl_data['shape'] = isset($row[56]) && $row[56] != '' ? $row[56] : null;
            $pearl_data['grade'] = isset($row[57]) && $row[57] != '' ? $row[57] : null;
            $pearl_data['setting'] = isset($row[58]) && $row[58] != '' ? $row[58] : null; 
            $pearl_data['total_count'] = isset($row[59]) && $row[59] != '' ? $row[59] : null; 
            $pearl_data['price_per_carat'] = isset($row[60]) && $row[60] != '' ? $row[60] : null; 
            $gemstone_data['gemstone'] = isset($row[61]) && $row[61] != '' ? $row[61] : null;
            $gemstone_data['nature'] = isset($row[62]) && $row[62] != '' ? $row[62] : null;
            $gemstone_data['color'] = isset($row[63]) && $row[63] != '' ? $row[63] : null;
            $gemstone_data['carat'] = isset($row[64]) && $row[64] != '' ? $row[64] : null;
            $gemstone_data['shape'] = isset($row[65]) && $row[65] != '' ? $row[65] : null;
            $gemstone_data['clarity'] = isset($row[66]) && $row[66] != '' ? $row[66] : null;
            $gemstone_data['cut'] = isset($row[67]) && $row[67] != '' ? $row[67] : null;
            $gemstone_data['setting'] = isset($row[68]) && $row[68] != '' ? $row[68] : null; 
            $gemstone_data['total_count'] = isset($row[69]) && $row[69] != '' ? $row[69] : null; 
            $gemstone_data['price_per_carat'] = isset($row[70]) && $row[70] != '' ? $row[70] : null; 
            $price_breakup = isset($row[71]) && $row[71] != '' ? $row[71] : null;
            $fix_price = isset($row[72]) && $row[72] != '' ? $row[72] : null;
            $fix_discount_type = isset($row[73]) && $row[73] != '' ? $row[73] : null;
            $fix_discount = isset($row[74]) && $row[74] != '' ? $row[74] : null;
            $making_calculation = isset($row[75]) && $row[75] != '' ? $row[75] : null;
            $fix_making_charge = isset($row[76]) && $row[76] != '' ? $row[76] : null;
            $making_charge_percentage = isset($row[77]) && $row[77] != '' ? $row[77] : null;
            $making_charge_d_type = isset($row[78]) && $row[78] != '' ? $row[78] : null;
            $making_charge_discount = isset($row[79]) && $row[79] != '' ? $row[79] : null;
            $diamond_d_type = isset($row[80]) && $row[80] != '' ? $row[80] : null;
            $diamond_discount = isset($row[81]) && $row[81] != '' ? $row[81] : null;
            $pearl_d_type = isset($row[82]) && $row[82] != '' ? $row[82] : null;
            $pearl_discount = isset($row[83]) && $row[83] != '' ? $row[83] : null;
            $gem_d_type = isset($row[84]) && $row[84] != '' ? $row[84] : null;
            $gem_discount = isset($row[85]) && $row[85] != '' ? $row[85] : null;
            $other_charge = isset($row[86]) && $row[86] != '' ? $row[86] : null;
            $other_d_type = isset($row[87]) && $row[87] != '' ? $row[87] : null;
            $other_discount = isset($row[88]) && $row[88] != '' ? $row[88] : null;
            $national_tax = isset($row[89]) && $row[89] != '' ? $row[89] : null;
            $minimum_amount = isset($row[90]) && $row[90] != '' ? $row[90] : null;
            $payment_g = isset($row[91]) && $row[91] != '' ? $row[91] : null;
            $cod = isset($row[92]) && $row[92] != '' ? $row[92] : null;
            $ccod = isset($row[93]) && $row[93] != '' ? $row[93] : null;
            $metatitle = isset($row[94]) && $row[94] != '' ? $row[94] : null;
            $metades = isset($row[95]) && $row[95] != '' ? $row[95] : null;
            $is_public = isset($row[96]) && $row[96] != '' ? $row[96] : null;
            $validData = true;
            $row[97] = '';
            if(empty($sku))
            {
                $row[97] .= 'SKU* |';
                $validData = false;
            }
            if(isset($family) && $family != null)
            {
                $family_check = Family::whereRaw('LOWER(family) = ?', [trim(strtolower($family))])->first();
                if($family_check && $family_check != null)
                {
                    $family_id = $family_check->id;
                }else{
                    $row[97] .= 'Product Family Not Found|';
                    $validData = false;
                }
            }
            if(empty($status))
            {
                $row[97] .= 'Status* |';
                $validData = false;
            }
            if(isset($status) && $status != '')
            {
                if (!in_array($status, ['ready_stock', 'by_order'])) {
                    $row[97] .= 'Invalid Status |';
                    $validData = false;
                } 
            }
            if(empty($title))
            {
                $row[97] .= 'Product Title* |';
                $validData = false;
            }
            if(!empty($unit))
            {
                $unit_check = Unit::whereRaw('LOWER(title) = ?', [trim(strtolower($unit))])->first();
                if($unit_check && $unit_check != null)
                {
                    $unit_id = $unit_check->title;
                }else{
                    $row[97] .= 'Unit Not Found|';
                    $validData = false;
                }
            }
            if(!empty($gender))
            {
                $gender_check = Gender::whereRaw('LOWER(title) = ?', [trim(strtolower($gender))])->first();
                if($gender_check && $gender_check != null)
                {
                    $gender_id = $gender_check->title;
                }else{
                    $row[97] .= 'Gender Not Found |';
                    $validData = false;
                }
            }
            if(!empty($occassion))
            {
                $occassion_check = Occasion::whereRaw('LOWER(title) = ?', [trim(strtolower($occassion))])->first();
                if($occassion_check && $occassion_check != null)
                {
                    $occassion_id = $occassion_check->id;
                }else{
                    $row[97] .= 'Occassion Not Found|';
                    $validData = false;
                }
            }
            if(!empty($trend))
            {
                $trend_check = Trend::whereRaw('LOWER(title) = ?', [trim(strtolower($trend))])->first();
                if($trend_check && $trend_check != null)
                {
                    $trend_id = $trend_check->id;
                }else{
                    $row[97] .= 'Trend Not Found|';
                    $validData = false;
                }
            }
            if(!empty($design))
            {
                $design_check = Designe::whereRaw('LOWER(title) = ?', [trim(strtolower($design))])->first();
                if($design_check && $design_check != null)
                {
                    $design_id = $design_check->id;
                }else{
                    $row[97] .= 'Design Not Found|';
                    $validData = false;
                }
            }
            if(!empty($style))
            {
                $style_check = Style::whereRaw('LOWER(title) = ?', [trim(strtolower($style))])->first();
                if($style_check && $style_check != null)
                {
                    $style_id = $style_check->id;
                }else{
                    $row[97] .= 'Style Found|';
                    $validData = false;
                }
            }
            if(!empty($brand))
            {
                $brand_check = Brand::whereRaw('LOWER(title) = ?', [trim(strtolower($brand))])->first();
                if($brand_check && $brand_check != null)
                {
                    $brand_id = $brand_check->title;
                }else{
                    $row[97] .= 'Brand Found|';
                    $validData = false;
                }
            }
            if(!empty($theme))
            {
                $theme_check = Theme::whereRaw('LOWER(title) = ?', [trim(strtolower($theme))])->first();
                if($theme_check && $theme_check != null)
                {
                    $theme_id = $theme_check->title;
                }else{
                    $row[97] .= 'Theme Not Found|';
                    $validData = false;
                }
            }
            if(!empty($measurements_unit))
            {
                $measurements_unit_check = Unit::whereRaw('LOWER(title) = ?', [trim(strtolower($measurements_unit))])->first();
                if($measurements_unit_check && $measurements_unit_check != null)
                {
                    $measurements_unit_id = $measurements_unit_check->title;
                }else{
                    $row[97] .= 'Measurement Unit Not Found|';
                    $validData = false;
                }
            }
            if(!empty($quantity_unit))
            {
                $quantity_unit_check = QUnit::whereRaw('LOWER(title) = ?', [trim(strtolower($quantity_unit))])->first();
                if($quantity_unit_check && $quantity_unit_check != null)
                {
                    $quantity_unit_id = $quantity_unit_check->title;
                }else{
                    $row[97] .= 'Quantity Unit Not Found|';
                    $validData = false;
                }
            }
            if(!empty($gross_weight_unit))
            {
                $gross_weight_unit_check = WUnit::whereRaw('LOWER(title) = ?', [trim(strtolower($gross_weight_unit))])->first();
                if($gross_weight_unit_check && $gross_weight_unit_check != null)
                {
                    $gross_weight_unit_id = $gross_weight_unit_check->title;
                }else{
                    $row[97] .= 'Gross Weight Unit Not Found|';
                    $validData = false;
                }
            }
            if(!empty($net_weight_unit))
            {
                $net_weight_unit_check = WUnit::whereRaw('LOWER(title) = ?', [trim(strtolower($net_weight_unit))])->first();
                if($net_weight_unit_check && $net_weight_unit_check != null)
                {
                    $net_weight_unit_id = $net_weight_unit_check->title;
                }else{
                    $row[97] .= 'Net Weight Unit Not Found|';
                    $validData = false;
                }
            }
            if(!empty($made_in))
            {
                $made_in_check = Country::whereRaw('LOWER(name) = ?', [trim(strtolower($made_in))])->first();
                if($made_in_check && $made_in_check != null)
                {
                    $made_in_id = $made_in_check->id;
                }else{
                    $row[97] .= 'Made In Not Found|';
                    $validData = false;
                }
            }
            if(!empty($popular_gemstone))
            {
                $popular_gemstone_check = PopularGemstone::whereRaw('LOWER(title) = ?', [trim(strtolower($popular_gemstone))])->first();
                if($popular_gemstone_check && $popular_gemstone_check != null)
                {
                    $popular_gemstone_id = $popular_gemstone_check->title;
                }else{
                    $row[97] .= 'Popular Gemstone Not Found|';
                    $validData = false;
                }
            }
            if(!empty($final_shape))
            {
                $final_shape_check = ProductShape::whereRaw('LOWER(title) = ?', [trim(strtolower($final_shape))])->where('type','gemstone')->first();
                if($final_shape_check && $final_shape_check != null)
                {
                    $final_shape_id = $final_shape_check->title;
                }else{
                    $row[97] .= 'Shape Not Found|';
                    $validData = false;
                }
            }
            if(!empty($final_color))
            {
                $final_color_check = ProductColor::whereRaw('LOWER(title) = ?', [trim(strtolower($final_color))])->where('type','gemstone')->first();
                if($final_color_check && $final_color_check != null)
                {
                    $final_color_id = $final_color_check->title;
                }else{
                    $row[97] .= 'Color Found|';
                    $validData = false;
                }
            }
            if(!empty($final_clarity))
            {
                $final_clarity_check = ProductClarity::whereRaw('LOWER(title) = ?', [trim(strtolower($final_clarity))])->where('type','gemstone')->first();
                if($final_clarity_check && $final_clarity_check != null)
                {
                    $final_clarity_id = $final_clarity_check->title;
                }else{
                    $row[97] .= 'Clarity Not Found|';
                    $validData = false;
                }
            }
            if(!empty($final_cut))
            {
                $final_cut_check = ProductCut::whereRaw('LOWER(title) = ?', [trim(strtolower($final_cut))])->where('type','gemstone')->first();
                if($final_cut_check && $final_cut_check != null)
                {
                    $final_cut_id = $final_cut_check->title;
                }else{
                    $row[97] .= 'Cut Not Found|';
                    $validData = false;
                }
            }
            if(!empty($final_treatment))
            {
                $final_treatment_check = GemstoneTreatment::whereRaw('LOWER(title) = ?', [trim(strtolower($final_treatment))])->first();
                if($final_treatment_check && $final_treatment_check != null)
                {
                    $final_treatment_id = $final_treatment_check->title;
                }else{
                    $row[97] .= 'Treatment Found|';
                    $validData = false;
                }
            }
            if(!empty($laboratory))
            {
                $laboratory_check = Laboratory::whereRaw('LOWER(title) = ?', [trim(strtolower($laboratory))])->first();
                if($laboratory_check && $laboratory_check != null)
                {
                    $laboratory_id = $laboratory_check->title;
                }else{
                    $row[97] .= 'Laboratory Found|';
                    $validData = false;
                }
            }
            if(isset($draft) && $draft != '')
            {
                if (!in_array($draft, ['yes', 'no','Yes', 'No'])) {
                    $row[97] .= 'Invalid Draft Status |';
                    $validData = false;
                } 
            }
            if(isset($price_type) && $price_type != '')
            {
                if (!in_array($price_type, ['dynamic', 'fix_price','no_price'])) {
                    $row[97] .= 'Invalid Price Type |';
                    $validData = false;
                } 
            }
            if(isset($price_breakup) && $price_breakup != '')
            {
                if (!in_array($price_breakup, ['yes', 'no','Yes', 'No'])) {
                    $row[97] .= 'Invalid Price Breakup |';
                    $validData = false;
                } 
            }
            if(isset($fix_discount_type) && $fix_discount_type != '')
            {
                if (!in_array($fix_discount_type, ['percentage', 'price', 'Percentage', 'Price'])) {
                    $row[97] .= 'Invalid Fix Price Discount Type |';
                    $validData = false;
                } 
            }
            if(isset($making_calculation) && $making_calculation != '')
            {
                if (!in_array($making_calculation, ['percentage', 'price', 'Percentage', 'Price'])) {
                    $row[97] .= 'Invalid Making charge Calculation Type |';
                    $validData = false;
                } 
            }
            if(isset($making_charge_d_type) && $making_charge_d_type != '')
            {
                if (!in_array($making_charge_d_type, ['percentage', 'price', 'Percentage', 'Price'])) {
                    $row[97] .= 'Invalid Making Charge Discount type |';
                    $validData = false;
                } 
            }
            if(isset($diamond_d_type) && $diamond_d_type != '')
            {
                if (!in_array($diamond_d_type, ['percentage', 'price', 'Percentage', 'Price'])) {
                    $row[97] .= 'Invalid Diamond Discount type |';
                    $validData = false;
                } 
            }
            if(isset($pearl_d_type) && $pearl_d_type != '')
            {
                if (!in_array($pearl_d_type, ['percentage', 'price', 'Percentage', 'Price'])) {
                    $row[97] .= 'Invalid Pearl Discount type |';
                    $validData = false;
                } 
            }
            if(isset($gem_d_type) && $gem_d_type != '')
            {
                if (!in_array($gem_d_type, ['percentage', 'price', 'Percentage', 'Price'])) {
                    $row[97] .= 'Invalid Gemstone Discount type |';
                    $validData = false;
                } 
            }
            if(isset($other_d_type) && $other_d_type != '')
            {
                if (!in_array($other_d_type, ['percentage', 'price', 'Percentage', 'Price'])) {
                    $row[97] .= 'Invalid Orher Charge Discount type |';
                    $validData = false;
                } 
            }
            if(isset($payment_g) && $payment_g != '')
            {
                if (!in_array($payment_g, ['yes', 'no','Yes', 'No'])) {
                    $row[97] .= 'Invalid Payment Gateway Selection |';
                    $validData = false;
                } 
            }
            if(isset($cod) && $cod != '')
            {
                if (!in_array($cod, ['yes', 'no','Yes', 'No'])) {
                    $row[97] .= 'Invalid Cod Selection |';
                    $validData = false;
                } 
            }
            if(isset($ccod) && $ccod != '')
            {
                if (!in_array($ccod, ['yes', 'no','Yes', 'No'])) {
                    $row[97] .= 'Invalid CCod |';
                    $validData = false;
                } 
            }
            if(isset($is_public) && $is_public != '')
            {
                if (!in_array($is_public, ['1', '0'])) {
                    $row[97] .= 'Invalid Is Public Product Status |';
                    $validData = false;
                } 
            }
            if(isset($diamond_data) && $diamond_data != '')
            {
                $d_store_data = [];
                if(isset($diamond_data['nature']) && $diamond_data['nature'] != '')
                {
                    $d_nature = explode('|',$diamond_data['nature']);
                    $d_nature_lower = array_map('strtolower', $d_nature);
                    $diamond_nature_lower = array_map('strtolower', $diamond_nature);
                    $d_nature_missing_values = array_diff($d_nature_lower, $diamond_nature_lower);
                    $d_m_count = 0;
                    if(count($d_nature_missing_values) > 0)
                    {
                        $row[97] .= 'Invalid Diamond Nature |';
                        $validData = false;
                        $d_m_count++;
                    }else {
                        $d_nature_matched_lower = array_intersect($d_nature_lower, $diamond_nature_lower);
                        $d_nature_matched_values = [];
                        foreach ($d_nature_matched_lower as $matched) {
                            $index = array_search($matched, $diamond_nature_lower);
                            if ($index !== false) {
                                $d_nature_matched_values[] = $diamond_nature[$index];
                            }
                        }
                        $d_nature = $d_nature_matched_values;
                    }
                    if (isset($diamond_data['fancy_color']) && $diamond_data['fancy_color'] != null) {
                        $d_fancy_color = explode('|', $diamond_data['fancy_color']);
                        $d_fancy_color_lower = array_map('strtolower', $d_fancy_color);
                        $diamond_fancy_color_lower = array_map('strtolower', $diamond_fancy_color);
                        $d_fancy_missing_values = array_diff($d_fancy_color_lower, $diamond_fancy_color_lower);
                        if (count($d_fancy_missing_values) > 0) {
                            $row[97] .= 'Invalid Diamond Fancy Color |';
                            $validData = false;
                            $d_m_count++;
                        } else {
                            $d_fancy_matched_lower = array_intersect($d_fancy_color_lower, $diamond_fancy_color_lower);
                            $d_fancy_matched_values = [];
                            foreach ($d_fancy_matched_lower as $matched) {
                                $index = array_search($matched, $diamond_fancy_color_lower);
                                if ($index !== false) {
                                    $d_fancy_matched_values[] = $diamond_fancy_color[$index];
                                }
                            }
                            $d_fancy_color = $d_fancy_matched_values;
                        }
                    }
                    
                    if (isset($diamond_data['color']) && $diamond_data['color'] != null) {
                        $d_color = explode('|', $diamond_data['color']);
                        $d_color_lower = array_map('strtolower', $d_color);
                        $diamond_color_lower = array_map('strtolower', $diamond_color);
                        $d_color_missing_values = array_diff($d_color_lower, $diamond_color_lower);
                        if (count($d_color_missing_values) > 0) {
                            $row[97] .= 'Invalid Diamond Color |';
                            $validData = false;
                            $d_m_count++;
                        } else {
                            $d_color_matched_lower = array_intersect($d_color_lower, $diamond_color_lower);
                            $d_color_matched_values = [];
                            foreach ($d_color_matched_lower as $matched) {
                                $index = array_search($matched, $diamond_color_lower);
                                if ($index !== false) {
                                    $d_color_matched_values[] = $diamond_color[$index];
                                }
                            }
                            $d_color = $d_color_matched_values;
                        }
                    }
                    
                    if (isset($diamond_data['carat']) && $diamond_data['carat'] != null) {
                        $d_carat = explode('|', $diamond_data['carat']);
                    }
                    
                    if (isset($diamond_data['shape']) && $diamond_data['shape'] != null) {
                        $d_shape = explode('|', $diamond_data['shape']);
                        $d_shape_lower = array_map('strtolower', $d_shape);
                        $diamond_shape_lower = array_map('strtolower', $diamond_shape);
                        $d_shape_missing_values = array_diff($d_shape_lower, $diamond_shape_lower);
                        if (count($d_shape_missing_values) > 0) {
                            $row[97] .= 'Invalid Diamond Shape |';
                            $validData = false;
                            $d_m_count++;
                        } else {
                            $d_shape_matched_lower = array_intersect($d_shape_lower, $diamond_shape_lower);
                            $d_shape_matched_values = [];
                            foreach ($d_shape_matched_lower as $matched) {
                                $index = array_search($matched, $diamond_shape_lower);
                                if ($index !== false) {
                                    $d_shape_matched_values[] = $diamond_shape[$index];
                                }
                            }
                            $d_shape = $d_shape_matched_values;
                        }
                    }
                    
                    if (isset($diamond_data['clarity']) && $diamond_data['clarity'] != null) {
                        $d_clarity = explode('|', $diamond_data['clarity']);
                        $d_clarity_lower = array_map('strtolower', $d_clarity);
                        $diamond_clarity_lower = array_map('strtolower', $diamond_clarity);
                        $d_clarity_missing_values = array_diff($d_clarity_lower, $diamond_clarity_lower);
                        if (count($d_clarity_missing_values) > 0) {
                            $row[97] .= 'Invalid Diamond Clarity |';
                            $validData = false;
                            $d_m_count++;
                        } else {
                            $d_clarity_matched_lower = array_intersect($d_clarity_lower, $diamond_clarity_lower);
                            $d_clarity_matched_values = [];
                            foreach ($d_clarity_matched_lower as $matched) {
                                $index = array_search($matched, $diamond_clarity_lower);
                                if ($index !== false) {
                                    $d_clarity_matched_values[] = $diamond_clarity[$index];
                                }
                            }
                            $d_clarity = $d_clarity_matched_values;
                        }
                    }
                    
                    if (isset($diamond_data['cut']) && $diamond_data['cut'] != null) {
                        $d_cut = explode('|', $diamond_data['cut']);
                        $d_cut_lower = array_map('strtolower', $d_cut);
                        $diamond_cut_lower = array_map('strtolower', $diamond_cut);
                        $d_cut_missing_values = array_diff($d_cut_lower, $diamond_cut_lower);
                        if (count($d_cut_missing_values) > 0) {
                            $row[97] .= 'Invalid Diamond Cut |';
                            $validData = false;
                            $d_m_count++;
                        } else {
                            $d_cut_matched_lower = array_intersect($d_cut_lower, $diamond_cut_lower);
                            $d_cut_matched_values = [];
                            foreach ($d_cut_matched_lower as $matched) {
                                $index = array_search($matched, $diamond_cut_lower);
                                if ($index !== false) {
                                    $d_cut_matched_values[] = $diamond_cut[$index];
                                }
                            }
                            $d_cut = $d_cut_matched_values;
                        }
                    }
                    
                    if (isset($diamond_data['setting']) && $diamond_data['setting'] != null) {
                        $d_setting = explode('|', $diamond_data['setting']);
                        $d_setting_lower = array_map('strtolower', $d_setting);
                        $diamond_setting_lower = array_map('strtolower', $diamond_setting);
                        $d_setting_missing_values = array_diff($d_setting_lower, $diamond_setting_lower);
                        if (count($d_setting_missing_values) > 0) {
                            $row[97] .= 'Invalid Diamond Setting |';
                            $validData = false;
                            $d_m_count++;
                        } else {
                            $d_setting_matched_lower = array_intersect($d_setting_lower, $diamond_setting_lower);
                            $d_setting_matched_values = [];
                            foreach ($d_setting_matched_lower as $matched) {
                                $index = array_search($matched, $diamond_setting_lower);
                                if ($index !== false) {
                                    $d_setting_matched_values[] = $diamond_setting[$index];
                                }
                            }
                            $d_setting = $d_setting_matched_values;
                        }
                    }
                    if(isset($diamond_data['total_count']) && $diamond_data['total_count'] != null)
                    {
                        $d_total_count = explode('|',$diamond_data['total_count']);

                    }if(isset($diamond_data['price_per_carat']) && $diamond_data['price_per_carat'] != null)
                    {
                        $d_price_per_carat = explode('|',$diamond_data['price_per_carat']);
                    }  
                    if(isset($d_m_count) && $d_m_count == 0)
                    {
                        foreach($d_nature as $key => $val)
                        {
                            $total_diamond_weight = (isset($d_carat[$key]) ? floatval($d_carat[$key]) : 0) * (isset($d_total_count[$key]) ? floatval($d_total_count[$key]) : 0);
                            $final_diamond_price = (isset($total_diamond_weight) ? floatval($total_diamond_weight) : 0) * (isset($d_price_per_carat[$key]) ? floatval($d_price_per_carat[$key]) : 0);
                            $d_store_data[] = [
                                "attr_type" => isset($val) ? $val : '',
                                "attr_fancy_color" => isset($d_fancy_color[$key]) ? $d_fancy_color[$key] : '',
                                "attr_color" => isset($d_color[$key]) ? $d_color[$key] : '',
                                "attr_diamond_caret" => isset($d_carat[$key]) ? $d_carat[$key] : '',
                                "attr_shape" => isset($d_shape[$key]) ? $d_shape[$key] : '',
                                "attr_clarity" => isset($d_clarity[$key]) ? $d_clarity[$key] : '',
                                "attr_cut" => isset($d_cut[$key]) ? $d_cut[$key] : '',
                                "attr_setting" => isset($d_setting[$key]) ? $d_setting[$key] : '',
                                "attr_total_diamond_count" => isset($d_total_count[$key]) ? $d_total_count[$key] : '',
                                "attr_total_diamond_wight" => isset($total_diamond_weight) ? $total_diamond_weight : '',
                                "attr_diamond_per_carat" => isset($d_price_per_carat[$key]) ? $d_price_per_carat[$key] : '',
                                "attr_final_diamond_price" => isset($final_diamond_price) ? $final_diamond_price : '',
                            ];
                        }
                        $diamond_json = json_encode($d_store_data);
                    }
                }
            }
            if(isset($pearl_data) && $pearl_data != '')
            {
                $p_store_data = [];
                if(isset($pearl_data['nature']) && $pearl_data['nature'] != '')
                {
                    $p_nature = explode('|', $pearl_data['nature']);
                    $p_nature_lower = array_map('strtolower', $p_nature);
                    $pearl_nature_lower = array_map('strtolower', $pearl_nature);
                    $p_nature_missing_values = array_diff($p_nature_lower, $pearl_nature_lower);
                    $p_m_count = 0;

                    if (count($p_nature_missing_values) > 0) {
                        $row[97] .= 'Invalid Pearl Type |';
                        $validData = false;
                        $p_m_count++;
                    } else {
                        $p_nature_matched_lower = array_intersect($p_nature_lower, $pearl_nature_lower);
                        $p_nature_matched_values = [];
                        foreach ($p_nature_matched_lower as $matched) {
                            $index = array_search($matched, $pearl_nature_lower);
                            if ($index !== false) {
                                $p_nature_matched_values[] = $pearl_nature[$index];
                            }
                        }
                        $p_nature = $p_nature_matched_values;
                    }

                    if (isset($pearl_data['color']) && $pearl_data['color'] != null) {
                        $p_color = explode('|', $pearl_data['color']);
                        $p_color_lower = array_map('strtolower', $p_color);
                        $pearl_color_lower = array_map('strtolower', $pearl_color);
                        $p_color_missing_values = array_diff($p_color_lower, $pearl_color_lower);
                        if (count($p_color_missing_values) > 0) {
                            $row[97] .= 'Invalid Pearl Color |';
                            $validData = false;
                            $p_m_count++;
                        } else {
                            $p_color_matched_lower = array_intersect($p_color_lower, $pearl_color_lower);
                            $p_color_matched_values = [];
                            foreach ($p_color_matched_lower as $matched) {
                                $index = array_search($matched, $pearl_color_lower);
                                if ($index !== false) {
                                    $p_color_matched_values[] = $pearl_color[$index];
                                }
                            }
                            $p_color = $p_color_matched_values;
                        }
                    }

                    if (isset($pearl_data['carat']) && $pearl_data['carat'] != null) {
                        $p_carat = explode('|', $pearl_data['carat']);
                    }

                    if (isset($pearl_data['pearl']) && $pearl_data['pearl'] != null) {
                        $p_pearl = explode('|', $pearl_data['pearl']);
                        $p_pearl_lower = array_map('strtolower', $p_pearl);
                        $pearl_pearl_lower = array_map('strtolower', $pearl_pearl);
                        $p_pearl_missing_values = array_diff($p_pearl_lower, $pearl_pearl_lower);
                        if (count($p_pearl_missing_values) > 0) {
                            $row[97] .= 'Invalid Pearl Value |';
                            $validData = false;
                            $p_m_count++;
                        } else {
                            $p_pearl_matched_lower = array_intersect($p_pearl_lower, $pearl_pearl_lower);
                            $p_pearl_matched_values = [];
                            foreach ($p_pearl_matched_lower as $matched) {
                                $index = array_search($matched, $pearl_pearl_lower);
                                if ($index !== false) {
                                    $p_pearl_matched_values[] = $pearl_pearl[$index];
                                }
                            }
                            $p_pearl = $p_pearl_matched_values;
                        }
                    }

                    if (isset($pearl_data['shape']) && $pearl_data['shape'] != null) {
                        $p_shape = explode('|', $pearl_data['shape']);
                        $p_shape_lower = array_map('strtolower', $p_shape);
                        $pearl_shape_lower = array_map('strtolower', $pearl_shape);
                        $p_shape_missing_values = array_diff($p_shape_lower, $pearl_shape_lower);
                        if (count($p_shape_missing_values) > 0) {
                            $row[97] .= 'Invalid Pearl Shape |';
                            $validData = false;
                            $p_m_count++;
                        } else {
                            $p_shape_matched_lower = array_intersect($p_shape_lower, $pearl_shape_lower);
                            $p_shape_matched_values = [];
                            foreach ($p_shape_matched_lower as $matched) {
                                $index = array_search($matched, $pearl_shape_lower);
                                if ($index !== false) {
                                    $p_shape_matched_values[] = $pearl_shape[$index];
                                }
                            }
                            $p_shape = $p_shape_matched_values;
                        }
                    }

                    if (isset($pearl_data['grade']) && $pearl_data['grade'] != null) {
                        $p_grade = explode('|', $pearl_data['grade']);
                        $p_grade_lower = array_map('strtolower', $p_grade);
                        $pearl_grade_lower = array_map('strtolower', $pearl_grade);
                        $p_grade_missing_values = array_diff($p_grade_lower, $pearl_grade_lower);
                        if (count($p_grade_missing_values) > 0) {
                            $row[97] .= 'Invalid Pearl Grade |';
                            $validData = false;
                            $p_m_count++;
                        } else {
                            $p_grade_matched_lower = array_intersect($p_grade_lower, $pearl_grade_lower);
                            $p_grade_matched_values = [];
                            foreach ($p_grade_matched_lower as $matched) {
                                $index = array_search($matched, $pearl_grade_lower);
                                if ($index !== false) {
                                    $p_grade_matched_values[] = $pearl_grade[$index];
                                }
                            }
                            $p_grade = $p_grade_matched_values;
                        }
                    }

                    if (isset($pearl_data['setting']) && $pearl_data['setting'] != null) {
                        $p_setting = explode('|', $pearl_data['setting']);
                        $p_setting_lower = array_map('strtolower', $p_setting);
                        $pearl_setting_lower = array_map('strtolower', $pearl_setting);
                        $p_setting_missing_values = array_diff($p_setting_lower, $pearl_setting_lower);
                        if (count($p_setting_missing_values) > 0) {
                            $row[97] .= 'Invalid Pearl Setting |';
                            $validData = false;
                            $p_m_count++;
                        } else {
                            $p_setting_matched_lower = array_intersect($p_setting_lower, $pearl_setting_lower);
                            $p_setting_matched_values = [];
                            foreach ($p_setting_matched_lower as $matched) {
                                $index = array_search($matched, $pearl_setting_lower);
                                if ($index !== false) {
                                    $p_setting_matched_values[] = $pearl_setting[$index];
                                }
                            }
                            $p_setting = $p_setting_matched_values;
                        }
                    }
                    if(isset($pearl_data['total_count']) && $pearl_data['total_count'] != null)
                    {
                        $p_total_count = explode('|',$pearl_data['total_count']);

                    }if(isset($pearl_data['price_per_carat']) && $pearl_data['price_per_carat'] != null)
                    {
                        $p_price_per_carat = explode('|',$pearl_data['price_per_carat']);

                    }
                    if(isset($p_m_count) && $p_m_count == 0)
                    {
                        foreach($p_nature as $key => $val)
                        {
                            $p_total_diamond_weight = (isset($p_carat[$key]) ? floatval($p_carat[$key]) : 0) * (isset($p_total_count[$key]) ? floatval($p_total_count[$key]) : 0);
                            $p_final_diamond_price = (isset($p_total_diamond_weight) ? floatval($p_total_diamond_weight) : 0) * (isset($p_price_per_carat[$key]) ? floatval($p_price_per_carat[$key]) : 0);
                            $p_store_data[] = [
                                "attr_pearl_type" => isset($val) ? $val : '',
                                "attr_pearl_color" => isset($p_color[$key]) ? $p_color[$key] : '',
                                "attr_pearl_caret" => isset($p_carat[$key]) ? $p_carat[$key] : '',
                                "attr_pearl_gem" => isset($p_pearl[$key]) ? $p_pearl[$key] : '',
                                "attr_pearl_shape" => isset($p_shape[$key]) ? $p_shape[$key] : '',
                                "attr_pearl_grade" => isset($p_grade[$key]) ? $p_grade[$key] : '',
                                "attr_pearl_setting" => isset($p_setting[$key]) ? $p_setting[$key] : '',
                                "attr_pearl_total_gem_count" => isset($p_total_count[$key]) ? $p_total_count[$key] : '',
                                "attr_pearl_total_wight" => isset($p_total_diamond_weight) ? $p_total_diamond_weight : '',
                                "pearl_price_carat" => isset($p_price_per_carat[$key]) ? $p_price_per_carat[$key] : '',
                                "pearl_final_total" => isset($p_final_diamond_price) ? $p_final_diamond_price : '',
                            ];
                        }
                        $pearl_json = json_encode($p_store_data);
                    }
                }
            }
            if(isset($gemstone_data) && $gemstone_data != '')
            {
                $g_store_data = [];
                if(isset($gemstone_data['gemstone']) && $gemstone_data['gemstone'] != '')
                {
                    $g_gemstone = explode('|', $gemstone_data['gemstone']);
                    $g_gemstone_lower = array_map('strtolower', $g_gemstone);
                    $gem_gemstone_lower = array_map('strtolower', $gem_gemstone);
                    $g_gemstone_missing_values = array_diff($g_gemstone_lower, $gem_gemstone_lower);
                    $g_m_count = 0;

                    if (count($g_gemstone_missing_values) > 0) {
                        $row[97] .= 'Invalid Gemstone Value |';
                        $validData = false;
                        $g_m_count++;
                    } else {
                        $g_gemstone_matched_lower = array_intersect($g_gemstone_lower, $gem_gemstone_lower);
                        $g_gemstone_matched_values = [];
                        foreach ($g_gemstone_matched_lower as $matched) {
                            $index = array_search($matched, $gem_gemstone_lower);
                            if ($index !== false) {
                                $g_gemstone_matched_values[] = $gem_gemstone[$index];
                            }
                        }
                        $g_gemstone = $g_gemstone_matched_values;
                    }

                    if (isset($gemstone_data['nature']) && $gemstone_data['nature'] != null) {
                        $g_nature = explode('|', $gemstone_data['nature']);
                        $g_nature_lower = array_map('strtolower', $g_nature);
                        $gem_nature_lower = array_map('strtolower', $gem_nature);
                        $g_nature_missing_values = array_diff($g_nature_lower, $gem_nature_lower);
                        if (count($g_nature_missing_values) > 0) {
                            $row[97] .= 'Invalid Gemstone Type |';
                            $validData = false;
                            $g_m_count++;
                        } else {
                            $g_nature_matched_lower = array_intersect($g_nature_lower, $gem_nature_lower);
                            $g_nature_matched_values = [];
                            foreach ($g_nature_matched_lower as $matched) {
                                $index = array_search($matched, $gem_nature_lower);
                                if ($index !== false) {
                                    $g_nature_matched_values[] = $gem_nature[$index];
                                }
                            }
                            $g_nature = $g_nature_matched_values;
                        }
                    }

                    if (isset($gemstone_data['color']) && $gemstone_data['color'] != null) {
                        $g_color = explode('|', $gemstone_data['color']);
                        $g_color_lower = array_map('strtolower', $g_color);
                        $gem_color_lower = array_map('strtolower', $gem_color);
                        $g_color_missing_values = array_diff($g_color_lower, $gem_color_lower);
                        if (count($g_color_missing_values) > 0) {
                            $row[97] .= 'Invalid Gemstone Color |';
                            $validData = false;
                            $g_m_count++;
                        } else {
                            $g_color_matched_lower = array_intersect($g_color_lower, $gem_color_lower);
                            $g_color_matched_values = [];
                            foreach ($g_color_matched_lower as $matched) {
                                $index = array_search($matched, $gem_color_lower);
                                if ($index !== false) {
                                    $g_color_matched_values[] = $gem_color[$index];
                                }
                            }
                            $g_color = $g_color_matched_values;
                        }
                    }

                    if (isset($gemstone_data['carat']) && $gemstone_data['carat'] != null) {
                        $g_carat = explode('|', $gemstone_data['carat']);
                    }

                    if (isset($gemstone_data['shape']) && $gemstone_data['shape'] != null) {
                        $g_shape = explode('|', $gemstone_data['shape']);
                        $g_shape_lower = array_map('strtolower', $g_shape);
                        $gem_shape_lower = array_map('strtolower', $gem_shape);
                        $g_shape_missing_values = array_diff($g_shape_lower, $gem_shape_lower);
                        if (count($g_shape_missing_values) > 0) {
                            $row[97] .= 'Invalid Gemstone Shape |';
                            $validData = false;
                            $g_m_count++;
                        } else {
                            $g_shape_matched_lower = array_intersect($g_shape_lower, $gem_shape_lower);
                            $g_shape_matched_values = [];
                            foreach ($g_shape_matched_lower as $matched) {
                                $index = array_search($matched, $gem_shape_lower);
                                if ($index !== false) {
                                    $g_shape_matched_values[] = $gem_shape[$index];
                                }
                            }
                            $g_shape = $g_shape_matched_values;
                        }
                    }

                    if (isset($gemstone_data['clarity']) && $gemstone_data['clarity'] != null) {
                        $g_clarity = explode('|', $gemstone_data['clarity']);
                        $g_clarity_lower = array_map('strtolower', $g_clarity);
                        $gem_clarity_lower = array_map('strtolower', $gem_clarity);
                        $g_clarity_missing_values = array_diff($g_clarity_lower, $gem_clarity_lower);
                        if (count($g_clarity_missing_values) > 0) {
                            $row[97] .= 'Invalid Gemstone Clarity |';
                            $validData = false;
                            $g_m_count++;
                        } else {
                            $g_clarity_matched_lower = array_intersect($g_clarity_lower, $gem_clarity_lower);
                            $g_clarity_matched_values = [];
                            foreach ($g_clarity_matched_lower as $matched) {
                                $index = array_search($matched, $gem_clarity_lower);
                                if ($index !== false) {
                                    $g_clarity_matched_values[] = $gem_clarity[$index];
                                }
                            }
                            $g_clarity = $g_clarity_matched_values;
                        }
                    }

                    if (isset($gemstone_data['cut']) && $gemstone_data['cut'] != null) {
                        $g_cut = explode('|', $gemstone_data['cut']);
                        $g_cut_lower = array_map('strtolower', $g_cut);
                        $gem_cut_lower = array_map('strtolower', $gem_cut);
                        $g_cut_missing_values = array_diff($g_cut_lower, $gem_cut_lower);
                        if (count($g_cut_missing_values) > 0) {
                            $row[97] .= 'Invalid Gemstone Cut |';
                            $validData = false;
                            $g_m_count++;
                        } else {
                            $g_cut_matched_lower = array_intersect($g_cut_lower, $gem_cut_lower);
                            $g_cut_matched_values = [];
                            foreach ($g_cut_matched_lower as $matched) {
                                $index = array_search($matched, $gem_cut_lower);
                                if ($index !== false) {
                                    $g_cut_matched_values[] = $gem_cut[$index];
                                }
                            }
                            $g_cut = $g_cut_matched_values;
                        }
                    }

                    if (isset($gemstone_data['setting']) && $gemstone_data['setting'] != null) {
                        $g_setting = explode('|', $gemstone_data['setting']);
                        $g_setting_lower = array_map('strtolower', $g_setting);
                        $gem_setting_lower = array_map('strtolower', $gem_setting);
                        $g_setting_missing_values = array_diff($g_setting_lower, $gem_setting_lower);
                        if (count($g_setting_missing_values) > 0) {
                            $row[97] .= 'Invalid Gemstone Setting |';
                            $validData = false;
                            $g_m_count++;
                        } else {
                            $g_setting_matched_lower = array_intersect($g_setting_lower, $gem_setting_lower);
                            $g_setting_matched_values = [];
                            foreach ($g_setting_matched_lower as $matched) {
                                $index = array_search($matched, $gem_setting_lower);
                                if ($index !== false) {
                                    $g_setting_matched_values[] = $gem_setting[$index];
                                }
                            }
                            $g_setting = $g_setting_matched_values;
                        }
                    }
                    if(isset($gemstone_data['total_count']) && $gemstone_data['total_count'] != null)
                    {
                        $g_total_count = explode('|',$gemstone_data['total_count']);

                    }if(isset($gemstone_data['price_per_carat']) && $gemstone_data['price_per_carat'] != null)
                    {
                        $g_price_per_carat = explode('|',$gemstone_data['price_per_carat']);

                    }
                    if(isset($g_m_count) && $g_m_count == 0)
                    {
                        foreach($g_nature as $key => $val)
                        {
                            $g_total_diamond_weight = (isset($g_carat[$key]) ? floatval($g_carat[$key]) : 0) * (isset($g_total_count[$key]) ? floatval($g_total_count[$key]) : 0);
                            $g_final_diamond_price = (isset($g_total_diamond_weight) ? floatval($g_total_diamond_weight) : 0) * (isset($g_price_per_carat[$key]) ? floatval($g_price_per_carat[$key]) : 0);
                            $g_store_data[] = [
                                "attr_gemstone_type" => isset($val) ? $val : '',
                                "attr_gemstone_color" => isset($g_color[$key]) ? $g_color[$key] : '',
                                "attr_gemstone_caret" => isset($g_carat[$key]) ? $g_carat[$key] : '',
                                "attr_gemstone_gem" => isset($g_gemstone[$key]) ? $g_gemstone[$key] : '',
                                "attr_gemstone_shape" => isset($g_shape[$key]) ? $g_shape[$key] : '',
                                "attr_gemstone_clarity" => isset($g_clarity[$key]) ? $g_clarity[$key] : '',
                                "attr_gemstone_cut" => isset($g_cut[$key]) ? $g_cut[$key] : '',
                                "attr_gemstone_setting" => isset($g_setting[$key]) ? $g_setting[$key] : '',
                                "attr_gemstone_total_gem_count" => isset($g_total_count[$key]) ? $g_total_count[$key] : '',
                                "attr_gemstone_total_wight" => isset($g_total_diamond_weight) ? $g_total_diamond_weight : '',
                                "gemstone_price_carat" => isset($g_price_per_carat[$key]) ? $g_price_per_carat[$key] : '',
                                "gemstone_final_total" => isset($g_final_diamond_price) ? $g_final_diamond_price : '',
                            ];
                        }
                        $gemstone_json = json_encode($g_store_data);
                    }
                    
                }
            }
            if(isset($validData) && $validData == true)
            {
                $title = utf8_encode($title);
                $title = preg_replace('/[^\x20-\x7E]/', '', $title);
                // dd($family_id,$gender_id,$occassion_id,$trend_id,$design_id,$style_id,$brand_id,$theme_id,$quantity_unit_id,$gross_weight_unit_id,$net_weight_unit_id,$made_in_id,$metal_color_id,$metal_purity_id,$metal_unit_id,$laboratory_id);
                $data['p_category'] = $cat_id;
                $data['p_family'] = isset($family_id) ? $family_id : null;
                $data['p_tags'] = isset($tags) ? $tags : null;
                $data['p_status'] = isset($status) ? $status : null;
                $data['p_avail_stock_qty'] = isset($avail_stock_qty) ? $avail_stock_qty : null;
                $data['p_ltd_stock_qty'] = isset($indicate_stock_qty) ? $indicate_stock_qty : null;
                $data['p_min_order_qty'] = isset($minimum_stock_qty) ? $minimum_stock_qty : null;
                $data['p_title'] = isset($title) ? $title : null;
                $data['p_sku'] = isset($sku) ? $sku : null;
                $data['p_description'] = isset($description) ? $description : null;
                $data['p_gender'] = isset($gender_id) ? $gender_id : null;
                $data['p_design'] = isset($design_id) ? $design_id : null;
                $data['p_brand'] = isset($brand_id) ? $brand_id : null; 
                $data['p_theme'] = isset($theme_id) ? $theme_id : null;
                $data['p_style'] = isset($style_id) ? $style_id : null;
                $data['p_size'] = isset($size) ? $size : null;
                $data['p_unit'] = isset($unit_id) ? $unit_id : null;
                $data['p_occasion'] = isset($occassion_id) ? $occassion_id : null;
                $data['p_trend'] = isset($trend_id) ? $trend_id : null;
                $data['p_measurement'] = isset($measurements) ? $measurements : null;
                $data['p_measurement_unit'] = isset($measurements_unit_id) ? $measurements_unit_id : null;
                $data['p_qty'] = isset($quantity) ? $quantity : null;
                $data['p_qty_unit'] = isset($quantity_unit_id) ? $quantity_unit_id : null;
                $data['p_gross_weight'] = isset($gross_weight) ? $gross_weight : null;
                $data['p_gross_weight_unit'] = isset($gross_weight_unit_id) ? $gross_weight_unit_id : null;
                $data['p_net_weight'] = isset($net_weight ) ? $net_weight  : null;
                $data['p_n_weight_unit'] = isset($net_weight_unit_id) ? $net_weight_unit_id : null;
                $data['p_made_in'] = isset($made_in_id) ? $made_in_id : null;
                $data['p_metal'] = isset($metal_color_id) ? $metal_color_id : null;
                $data['p_popular_gemstone'] = isset($popular_gemstone_id) ? $popular_gemstone_id : null;
                $data['p_gemstone_shape'] = isset($final_shape_id) ? $final_shape_id : null;
                $data['p_gemstone_caret'] = isset($final_carat) ? $final_carat : null;
                $data['p_gemstone_color'] = isset($final_color_id) ? $final_color_id : null;
                $data['p_gemstone_clarity'] = isset($final_clarity_id) ? $final_clarity_id : null;
                $data['p_gemstone_cut'] = isset($final_cut_id) ? $final_cut_id : null;
                $data['p_gemstone_treatment'] = isset($final_treatment_id) ? $final_treatment_id : null;
                $data['p_laboraty'] = isset($laboratory_id) ? $laboratory_id : null;
                $data['p_certificate_no'] = isset($certificate_no) ? $certificate_no : null;
                $data['p_certificate_link'] = isset($certificate_link) ? $certificate_link : null;
                $data['diamond_details'] = isset($diamond_json) ? $diamond_json : null;
                $data['gemstone_details'] = isset($gemstone_json) ? $gemstone_json : null;
                $data['pearl_details'] = isset($pearl_json) ? $pearl_json : null;
                $data['p_pricetype'] = isset($price_type) ? $price_type : null;
                if($price_type == 'fix_price')
                {
                    $data['p_fix_price'] = isset($fix_price) ? $fix_price : null;
                    $data['fix_dis'] = isset($fix_discount_type) ? $fix_discount_type : null;
                    $data['p_discount'] = isset($fix_discount) ? $fix_discount : null;
                }else if($price_type == 'dynamic')
                {
                    $data['make_type'] = isset($making_calculation) ? $making_calculation : null;
                    $data['total_making_charges'] = isset($fix_making_charge) ? $fix_making_charge : null;
                    $data['make_dis'] = isset($making_charge_d_type) ? $making_charge_d_type : null;
                    $data['dis_making_price'] = isset($making_charge_discount) ? $making_charge_discount : null;
                    $data['only_making_charges'] = isset($making_charge_percentage) ? $making_charge_percentage : null;
                    $data['diamond_dis'] = isset($diamond_d_type) ? $diamond_d_type : null;
                    $data['dis_diamond_price'] = isset($diamond_discount) ? $diamond_discount : null;
                    $data['pearl_dis'] = isset($pearl_d_type) ? $pearl_d_type : null;
                    $data['p_dis_pearl_price'] = isset($pearl_discount) ? $pearl_discount : null;
                    $data['gemstone_dis'] = isset($gem_d_type) ? $gem_d_type : null;
                    $data['p_dis_gemstone_price'] = isset($gem_discount) ? $gem_discount  : null;
                    $data['p_total_other_charge'] = isset($other_charge) ? $other_charge : null;
                    $data['other_dis'] = isset($other_d_type) ? $other_d_type : null;
                    $data['p_dis_other_price'] = isset($other_discount) ? $other_discount : null;
                }
                $data['p_payment_g'] = isset($payment_g) ? $payment_g : null;
                $data['p_cod'] = isset($cod) ? $cod : null;
                $data['p_ccod'] = isset($ccod) ? $ccod : null;
                $data['p_national_tax'] = isset($national_tax) ? $national_tax : null;
                $data['p_above_amount'] = isset($minimum_amount) ? $minimum_amount : null;
                $data['meta_title'] = isset($metatitle) ? $metatitle : null;
                $data['meta_description'] = isset($metades) ? $metades : null;
                $data['file_id'] = $file->id;
                if(isset($slug) && $slug != null)
                {
                    $check_slug = Product::where('p_slug',$slug)->first();
                    if(!$check_slug)
                    {
                        $check_slug = VariantProduct::where('p_slug',$slug)->first();
                        if(isset($check_slug) && $check_slug != null)
                        {
                            $slug_update = $slug;
                            $n_slug = Str::slug($slug_update, '-');
                        }else{
                            $n_slug = SlugService::createSlug(Product::class, 'p_slug', $slug);
                        }
                    }else{
                        if(isset($check_slug) && $check_slug != null)
                        {
                            $slug_update = $slug;
                            $n_slug = Str::slug($slug_update, '-');
                        }else{
                            $n_slug = SlugService::createSlug(Product::class, 'p_slug', $slug);
                        }
                    }   
                }
                $data['p_slug'] = isset($n_slug) ? $n_slug : null;
                $duplicate = Product::where("p_sku",$sku)->first();
                if(!$duplicate)
                {
                    $duplicate = VariantProduct::where("p_sku",trim($sku))->first();
                }
                if(isset($duplicate) && $duplicate != null)
                {
                    $duplicate->update($data);
                    $updated_data[] = $row;
                    $updated_count++;
                }else{
                    $data['visiblity'] = 0;
                    $data['db_status'] = 'manually';
                    Product::create($data);
                    $completed_data[] = $row;
                    $completed_count++;
                }
            }else{
                $invalid_data[] = $row;
                $invalid_count++;
            }
            $progress = ($r_key + 1) / count($rows) * 100;
            $file->update(['progress' => $progress]);
        }
        $totalcount =$updated_count+$completed_count+$invalid_count;

        if(isset($completed_data) && count($completed_data) > 0)
        {
            $headers = ['sr', 'SKU','family','tags','Slug','product status','avaliable stock qty','indicate limited stock quantity','minimum order qty','product title','product description','gender','size','unit','occasion','trend','design','style','brand','theme','measurements','measurement unit','quantity','quantity unit','gross weight','gross weight unit','net weight','net weight unit','made in','Popular Gemstone','Shape','Caret','Colour','Clarity','Cut','Teatment','laboratory','certificate no','certificate link','visiblity','draft','price type','diamond nature','diamond Fancy Colour','diamond Colour','diamond Carat','diamond Shape','diamond Clarity','diamond Cut','diamond Setting','Total Diamond Count','Diamond Price Per Carat','Pearl Type','Pearl Colour','Pearl Carat','Pearl','Pearl Shape','Pearl Grade','Pearl Setting','Total Pearl Count','Pearl Price Per Carat','Gemstone','Gemstone Type','Gemstone Colour','Gemstone Carat','Gemstone Shape','Gemstone Clarity','Gemstone Cut','Gemstone Setting','Total Gemstone Count','Gemstone Price Per Carat','price breakup','fix price','fix price discount type','fix price discount','making charges calculation','fixed making charge','making charge percentage','making charge discount type','making charges discount','diamond discount type','diamond discount charge','pearl discount type','pearl discount charges','gemstone discount type','gemstone discount charges','other charges','other charges discount type','other discount charges','national tax','minimum amount','payment gateway','cod','ccod','meta title','meta description','is_public'];
            $filename = 'completed_'.uniqid() . '.csv';
            $filePath = public_path('importstatusfiles/'.$filename);
            $c_file = fopen($filePath, 'w+');
    
            // Add the headers from the first row of data
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            fputcsv($c_file, $headers);
            foreach ($completed_data as $row) {
                fputcsv($c_file, $row);
            }
    
            fclose($c_file);
            $file->update(['completed_filename' =>$filename]);
        }
        if(isset($invalid_data) && count($invalid_data) > 0)
        {
            $headers = ['sr', 'SKU','family','tags','Slug','product status','avaliable stock qty','indicate limited stock quantity','minimum order qty','product title','product description','gender','size','unit','occasion','trend','design','style','brand','theme','measurements','measurement unit','quantity','quantity unit','gross weight','gross weight unit','net weight','net weight unit','made in','Popular Gemstone','Shape','Caret','Colour','Clarity','Cut','Teatment','laboratory','certificate no','certificate link','visiblity','draft','price type','diamond nature','diamond Fancy Colour','diamond Colour','diamond Carat','diamond Shape','diamond Clarity','diamond Cut','diamond Setting','Total Diamond Count','Diamond Price Per Carat','Pearl Type','Pearl Colour','Pearl Carat','Pearl','Pearl Shape','Pearl Grade','Pearl Setting','Total Pearl Count','Pearl Price Per Carat','Gemstone','Gemstone Type','Gemstone Colour','Gemstone Carat','Gemstone Shape','Gemstone Clarity','Gemstone Cut','Gemstone Setting','Total Gemstone Count','Gemstone Price Per Carat','price breakup','fix price','fix price discount type','fix price discount','making charges calculation','fixed making charge','making charge percentage','making charge discount type','making charges discount','diamond discount type','diamond discount charge','pearl discount type','pearl discount charges','gemstone discount type','gemstone discount charges','other charges','other charges discount type','other discount charges','national tax','minimum amount','payment gateway','cod','ccod','meta title','meta description','is_public','Comment'];
            $filename = 'invalid_'.uniqid() . '.csv';
            $filePath = public_path('importstatusfiles/'.$filename);
            $c_file = fopen($filePath, 'w+');
    
            // Add the headers from the first row of data
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            fputcsv($c_file, $headers);
            foreach ($invalid_data as $row) {
                fputcsv($c_file, $row);
            }
            fclose($c_file);
            $file->update(['invalid_filename' =>$filename]);
        }
        if(isset($updated_data) && count($updated_data) > 0)
        {
            $headers = ['sr', 'SKU','family','tags','Slug','product status','avaliable stock qty','indicate limited stock quantity','minimum order qty','product title','product description','gender','size','unit','occasion','trend','design','style','brand','theme','measurements','measurement unit','quantity','quantity unit','gross weight','gross weight unit','net weight','net weight unit','made in','Popular Gemstone','Shape','Caret','Colour','Clarity','Cut','Teatment','laboratory','certificate no','certificate link','visiblity','draft','price type','diamond nature','diamond Fancy Colour','diamond Colour','diamond Carat','diamond Shape','diamond Clarity','diamond Cut','diamond Setting','Total Diamond Count','Diamond Price Per Carat','Pearl Type','Pearl Colour','Pearl Carat','Pearl','Pearl Shape','Pearl Grade','Pearl Setting','Total Pearl Count','Pearl Price Per Carat','Gemstone','Gemstone Type','Gemstone Colour','Gemstone Carat','Gemstone Shape','Gemstone Clarity','Gemstone Cut','Gemstone Setting','Total Gemstone Count','Gemstone Price Per Carat','price breakup','fix price','fix price discount type','fix price discount','making charges calculation','fixed making charge','making charge percentage','making charge discount type','making charges discount','diamond discount type','diamond discount charge','pearl discount type','pearl discount charges','gemstone discount type','gemstone discount charges','other charges','other charges discount type','other discount charges','national tax','minimum amount','payment gateway','cod','ccod','meta title','meta description','is_public'];
            $filename = 'updated_'.uniqid() . '.csv';
            $filePath = public_path('importstatusfiles/'.$filename);
            $c_file = fopen($filePath, 'w+');
    
            // Add the headers from the first row of data
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            fputcsv($c_file, $headers);
            foreach ($updated_data as $row) {
                fputcsv($c_file, $row);
            }
            fclose($c_file);
            $file->update(['updated_filename' =>$filename]);
        }
        if($totalcount == count($rows)){
            $file->update(['status'=>'Completed']);
        }else{
            $file->update(['status'=>'Cancel']);
        }
    }
    public function failed(\Throwable $exception)
    {
        try {
            $file = ProductImportFile::findOrFail($this->import_id);
            $file->update(['status' => 'Failed']);
        } catch (\Exception $e) {
            Log::error('Error updating status in failed job: ' . $e->getMessage());
        }

        Log::error('BulkImport job failed for file ID: ' . $this->import_id, ['exception' => $exception]);
    }
}
