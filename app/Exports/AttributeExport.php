<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;
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

class AttributeExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $selected_cat;

    public function __construct($selected_cat)
    {
        $this->selected_cat = $selected_cat;
    }

    public function collection()
    {
        // Retrieve data based on selected category
        $families = Family::whereRaw('FIND_IN_SET(?, category_id)', [$this->selected_cat])->get();
        $occasions = Occasion::all();
        $genderValues = Gender::all();
        $units = Unit::all();
        $brands = Brand::all();
        $trends = Trend::all();
        $designs = Designe::all();
        $styles = Style::all();
        $themes = Theme::all();
        $m_units = ['mm', 'cm', 'inch'];
        $q_units = QUnit::all();
        $w_units = WUnit::all();
        $countries = Country::all();
        $purities = MetalPurity::all();
        $metals = Metal::all();
        $labs = Laboratory::all();
        $diamond_types = DynamicDiamondType::all();
        $diamond_quality = DiamondRate::all();
        $diamond_nature = ProductNature::where('type','diamond')->get();
        $diamond_fancy_colors = ProductFancyColor::where('type','diamond')->get();
        $diamond_colors = ProductColor::where('type','diamond')->get();
        $diamond_shape = ProductShape::where('type','diamond')->get();
        $diamond_clarity = ProductClarity::where('type','diamond')->get();
        $diamond_cuts = ProductCut::where('type','diamond')->get();
        $diamond_settings = ProductSetting::where('type','diamond')->get();
        $pearl_type = ProductNature::where('type','pearl')->get();
        $pearl_colors = ProductColor::where('type','pearl')->get();
        $pearls = ProductPearl::where('type','pearl')->get();
        $pearl_shape = ProductShape::where('type','pearl')->get();
        $pearl_grades = ProductGrade::where('type','pearl')->get();
        $pearl_settings = ProductSetting::where('type','pearl')->get();
        $gemstone_gemstones = ProductGemstone::where('type','gemstone')->get();
        $gemstone_colors = ProductColor::where('type','gemstone')->get();
        $gemstone_shapes = ProductShape::where('type','gemstone')->get();
        $gemstone_clarity = ProductClarity::where('type','gemstone')->get();
        $gemstone_cuts = ProductCut::where('type','gemstone')->get();
        $gemstone_settings = ProductSetting::where('type','gemstone')->get();
        $popular_gemstone = PopularGemstone::all();
        $gemstone_treatment = GemstoneTreatment::all();
        $product_status = ['by_order','ready_stock'];
        $visibility = ['yes','no'];
        $price_type = ['dynamic','fix_price'];
        $making_charges_calculation = ['percentage', 'price'];
        $making_charge_discount_type = ['percentage', 'price'];
        $diamond_discount_type = ['percentage', 'price'];
        $pearl_discount_type = ['percentage', 'price'];
        $gemstone_discount_type = ['percentage', 'price'];
        $other_charges_discount_type = ['percentage', 'price'];
        $payment_gateway = ['yes','no'];
        $cod = ['yes','no'];
        $ccod = ['yes','no'];
        $is_public = ['1','0'];
        $maxCount = max(
            $families->count(),
            $genderValues->count(),
            $units->count(),
            $occasions->count(),
            $trends->count(),
            $designs->count(),
            $styles->count(),
            $themes->count(),
            $brands->count(),
            count($m_units),
            $q_units->count(),
            $w_units->count(),
            $countries->count(),
            $purities->count(),
            $metals->count(),
            $labs->count(),
            $diamond_types->count(),
            $diamond_quality->count(),
            $diamond_nature->count(),
            $diamond_fancy_colors->count(),
            $diamond_colors->count(),
            $diamond_shape->count(),
            $diamond_clarity->count(),
            $diamond_cuts->count(),
            $diamond_settings->count(),
            $pearl_type->count(),
            $pearl_colors->count(),
            $pearls->count(),
            $pearl_shape->count(),
            $pearl_grades->count(),
            $pearl_settings->count(),
            $gemstone_gemstones->count(),
            $gemstone_colors->count(),
            $gemstone_shapes->count(),
            $gemstone_clarity->count(),
            $gemstone_cuts->count(),
            $gemstone_settings->count(),
            $popular_gemstone->count(),
            $gemstone_treatment->count(),
            count($product_status),
            count($visibility),
            count($price_type),
            count($making_charges_calculation),
            count($making_charge_discount_type),
            count($diamond_discount_type),
            count($pearl_discount_type),
            count($gemstone_discount_type),
            count($other_charges_discount_type),
            count($payment_gateway),
            count($cod),
            count($ccod),
            count($is_public),
        );

        // Prepare the data
        $data = collect();

        // Add a blank row (empty array) before the data starts
        $data->push([]);

        for ($i = 0; $i < $maxCount; $i++) {
            $row = [
                'family' => isset($families[$i]) ? $families[$i]->family : '',
                'gender' => isset($genderValues[$i]) ? $genderValues[$i]->title : '',
                'unit' => isset($units[$i]) ? $units[$i]->title : '',
                'occasion' => isset($occasions[$i]) ? $occasions[$i]->title : '',
                'trend' => isset($trends[$i]) ? $trends[$i]->title : '',
                'design' => isset($designs[$i]) ? $designs[$i]->title : '',
                'style' => isset($styles[$i]) ? $styles[$i]->title : '',
                'theme' => isset($themes[$i]) ? $themes[$i]->title : '',
                'brand' => isset($brands[$i]) ? $brands[$i]->title : '',
                'm_unit' => isset($m_units[$i]) ? $m_units[$i] : '',
                'q_unit' => isset($q_units[$i]) ? $q_units[$i]->title : '',
                'w_unit' => isset($w_units[$i]) ? $w_units[$i]->title : '',
                'made_in' => isset($countries[$i]) ? $countries[$i]->name : '',
                'purity' => isset($purities[$i]) ? $purities[$i]->title : '',
                'metal' => isset($metals[$i]) ? $metals[$i]->title : '',
                'lab' => isset($labs[$i]) ? $labs[$i]->title : '',
                'd_type' => isset($diamond_types[$i]) ? $diamond_types[$i]->name : '',
                'd_quality' => isset($diamond_quality[$i]) ? $diamond_quality[$i]->quality : '',
                'd_nature' => isset($diamond_nature[$i]) ? $diamond_nature[$i]->title : '',
                'd_fancy' => isset($diamond_fancy_colors[$i]) ? $diamond_fancy_colors[$i]->title : '',
                'd_color' => isset($diamond_colors[$i]) ? $diamond_colors[$i]->title : '',
                'd_shape' => isset($diamond_shape[$i]) ? $diamond_shape[$i]->title : '',
                'd_clarity' => isset($diamond_clarity[$i]) ? $diamond_clarity[$i]->title : '',
                'd_cuts' => isset($diamond_cuts[$i]) ? $diamond_cuts[$i]->title : '',
                'd_setting' => isset($diamond_settings[$i]) ? $diamond_settings[$i]->title : '',
                'p_type' => isset($pearl_type[$i]) ? $pearl_type[$i]->title : '',
                'p_color' => isset($pearl_colors[$i]) ? $pearl_colors[$i]->title : '',
                'p_pearl' => isset($pearls[$i]) ? $pearls[$i]->title : '',
                'p_shape' => isset($pearl_shape[$i]) ? $pearl_shape[$i]->title : '',
                'p_grade' => isset($pearl_grades[$i]) ? $pearl_grades[$i]->title : '',
                'p_setting' => isset($pearl_settings[$i]) ? $pearl_settings[$i]->title : '',
                'g_gemstone' => isset($gemstone_gemstones[$i]) ? $gemstone_gemstones[$i]->title : '',
                'g_colors' => isset($gemstone_colors[$i]) ? $gemstone_colors[$i]->title : '',
                'g_shapes' => isset($gemstone_shapes[$i]) ? $gemstone_shapes[$i]->title : '',
                'g_clarity' => isset($gemstone_clarity[$i]) ? $gemstone_clarity[$i]->title : '',
                'g_cuts' => isset($gemstone_cuts[$i]) ? $gemstone_cuts[$i]->title : '',
                'g_setting' => isset($gemstone_settings[$i]) ? $gemstone_settings[$i]->title : '',
                'g_treatment' => isset($gemstone_treatment[$i]) ? $gemstone_treatment[$i]->title : '',
                'popular_gemstone' => isset($popular_gemstone[$i]) ? $popular_gemstone[$i]->title : '',
                'product_status' => isset($product_status[$i]) ? $product_status[$i] : '',
                'Visiblity' => isset($visibility[$i]) ? $visibility[$i] : '',
                'price_type' => isset($price_type[$i]) ? $price_type[$i] : '',
                'making_charges_calculation' => isset($making_charges_calculation[$i]) ? $making_charges_calculation[$i] : '',
                'diamond_discount_type' => isset($diamond_discount_type[$i]) ? $diamond_discount_type[$i] : '',
                'pearl_discount_type' => isset($pearl_discount_type[$i]) ? $pearl_discount_type[$i] : '',
                'gemstone_discount_type' => isset($gemstone_discount_type[$i]) ? $gemstone_discount_type[$i] : '',
                'other_charges_discount_type' => isset($other_charges_discount_type[$i]) ? $other_charges_discount_type[$i] : '',
                'payment_gateway' => isset($payment_gateway[$i]) ? $payment_gateway[$i] : '',
                'cod' => isset($cod[$i]) ? $cod[$i] : '',
                'ccod' => isset($ccod[$i]) ? $ccod[$i] : '',
                'is_public' => isset($is_public[$i]) ? $is_public[$i] : '',
            ];

            $data->push($row);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Product Family',
            'Gender',
            'Unit',
            'Occasion',
            'Trend',
            'Design',
            'Style',
            'Theme',
            'Brand',
            'Measurement Units',
            'Quantity Units',
            'Weight Units',
            'Made in',
            'Metal Purity',
            'Metals',
            'Laboratory',
            'Dynamic Diamond Type',
            'Dynamic Diamond Quality',
            'Diamond Nature',
            'Diamond Fancy Color',
            'Diamond Color',
            'Diamond Shape',
            'Diamond Clarity',
            'Diamond Cuts',
            'Diamond Settings',
            'Pearl Type',
            'Pearl Color',
            'Pearl',
            'Pearl Shape',
            'Pearl Grade',
            'Pearl Settings',
            'Gemstone',
            'Gemstone Colors',
            'Gemstone Shape',
            'Gemstone Clarity',
            'Gemstone Cut',
            'Gemstone Setting',
            'Popular Gemstone',
            'Gemstone Treatment',
            'Product Status',
            'Visiblity',
            'Price Type',
            'making_charges_calculation',
            'Diamond Discount Type',
            'Pearl Discount Type',
            'Gemstone Discount Type',
            'Other Charges Discount Type',
            'Payment Gateway',
            'COD',
            'CCOD',
            'Is Public',
        ];
    }

    public function map($row): array
    {
        return [
            $row['family'] ?? '',     // Ensure 'family' key exists or default to empty string
            $row['gender'] ?? '',
            $row['unit'] ?? '',
            $row['occasion'] ?? '',
            $row['trend'] ?? '',
            $row['design'] ?? '',
            $row['style'] ?? '',
            $row['theme'] ?? '',
            $row['brand'] ?? '',
            $row['m_unit'] ?? '',
            $row['q_unit'] ?? '',
            $row['w_unit'] ?? '',
            $row['made_in'] ?? '',
            $row['purity'] ?? '',
            $row['metal'] ?? '',
            $row['lab'] ?? '',
            $row['d_type'] ?? '',
            $row['d_quality'] ?? '',
            $row['d_nature'] ?? '',
            $row['d_fancy'] ?? '',
            $row['d_color'] ?? '',
            $row['d_shape'] ?? '',
            $row['d_clarity'] ?? '',
            $row['d_cuts'] ?? '',
            $row['d_setting'] ?? '',
            $row['p_type'] ?? '',
            $row['p_color'] ?? '',
            $row['p_pearl'] ?? '',
            $row['p_shape'] ?? '',
            $row['p_grade'] ?? '',
            $row['p_setting'] ?? '',
            $row['g_gemstone'] ?? '',
            $row['g_colors'] ?? '',
            $row['g_shapes'] ?? '',
            $row['g_clarity'] ?? '',
            $row['g_cuts'] ?? '',
            $row['g_setting'] ?? '',
            $row['g_treatment'] ?? '',
            $row['popular_gemstone'] ?? '',
            $row['product_status'] ?? '',
            $row['Visiblity'] ?? '',
            $row['price_type'] ?? '',
            $row['making_charges_calculation'] ?? '',
            $row['diamond_discount_type'] ?? '',
            $row['pearl_discount_type'] ?? '',
            $row['gemstone_discount_type'] ?? '',
            $row['other_charges_discount_type'] ?? '',
            $row['payment_gateway'] ?? '',
            $row['cod'] ?? '',
            $row['ccod'] ?? '',
            $row['is_public'] ?? '',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:AI1')->getFont()->setBold(true);
    }
    
}
