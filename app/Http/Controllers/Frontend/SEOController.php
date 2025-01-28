<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Models\Family;

class SEOController extends Controller
{
    public $businessData;
    
    public function __construct() {
        $this->businessData = (object) $this->getBusinessData();
    }
    /*
    * SEO Title description.
    */
    public function _seoTitleDescriptionHome()
    {
        // dd('gfdhgf');
        $business_name = $this->businessData->business_name;
        // $category = $this->businessData->primary_category;
        $city = $this->businessData->city;
        $keyword = $this->businessData->bd_keyword;
        // $nob = $this->businessData->bd_all_business_nature;
        $primary_cat = $this->businessData->primary_category;
        $secondary_cat = $this->businessData->secondary_category;
        $primary_nob = $this->businessData->business_nature;
        // $category = Str::replace(",", ", ", $category);
        // $nob = Str::replace(",", ", ", $nob);
        return array('title' => "$business_name online website, $primary_cat store in $city",
            'description' => "$business_name official website for online jewellery shopping in India. Buy top quality $primary_cat at wholesale prices, find popular designs, view online catalog, discover new jewelry trends, visit our $primary_cat $primary_nob in $city."
        );
        // return array('title' => "$business_name - $primary_cat, $secondary_cat Showroom in $city",
        //     'description' => "Welcome to $business_name official website for online jewellery shopping in India. We are $primary_cat, $secondary_cat $primary_nob based in $city."
        // );
        // return array('title' => "$business_name - $primary_cat, $secondary_cat Showroom in $city",
        //     'description' => "Welcome to $business_name official business website. We are $primary_cat, $secondary_cat $primary_nob based in $city."
        // );
    }
//     public function _seoTitleDescriptionPDFCatalogue()
//     {
//         $business_name = $this->businessData->bd_business_name;
//         $category = $this->businessData->bd_all_categories;
//         $city = $this->businessData->bd_city;
//         $keyword = $this->businessData->bd_keyword;
//         $nob = $this->businessData->bd_all_business_nature;
//         $primary_cat = $this->businessData->bd_primary_category;
//         $primary_nob = $this->businessData->bd_primary_business_nature;
//         $category = Str::replace(",", ", ", $category);
//         $nob = Str::replace(",", ", ", $nob);
//         return array('title' => "Download Free Designs Catalogue PDF by $business_name",
//             'description' => "Download Latest Designs PDF Catalog with Offer Price of $category and Buy it Online or Visit Our Store in $city."
//         );
//     }

//     /*
//      * SEO Title description.
//     */
//     public function _seoTitleDescriptionLogin()
//     {
//         $business_name = $this->businessData->bd_business_name;
//         $category = $this->businessData->bd_all_categories;
//         $city = $this->businessData->bd_city;
//         $keyword = $this->businessData->bd_keyword;
//         $nob = $this->businessData->bd_all_business_nature;
//         $primary_cat = $this->businessData->bd_primary_category;
//         $primary_nob = $this->businessData->bd_primary_business_nature;
//         $category = Str::replace(",", ", ", $category);
//         $nob = Str::replace(",", ", ", $nob);
//         return array('title' => "Best Offers on $category in $city",
//             'description' => "We have made it much easier to create your wish-list and place orders online, simply register with $business_name to receive latest offers."
//         );
//     }

//     /*
//      * Title Description for Product List Page.
//     */

    public function _seoTitleDescriptionProductList()
    {
        $business_name = $this->businessData->business_name;
        // $category = $this->businessData->category;
        $city = $this->businessData->city;
        $state = $this->businessData->stste;
        $keyword = $this->businessData->bd_keyword;
        $nob = $this->businessData->business_nature;
        $primary_cat = $this->businessData->category;
        $primary_nob = $this->businessData->business_nature;
        $products = "ring, necklace, earring";
        // $category = Str::replace(",", ", ", $category);
        // $nob = Str::replace(",", ", ", $nob);
        $footer_product_family = Family::whereHas('products', function ($query) {
                    $query->whereNotNull('p_family');
                })->limit(3)->get();
        $footer_product_family_1 = '';
        $footer_product_family_2 = '';
        $footer_product_family_3 = '';
        if(isset($footer_product_family[0]->family) && !empty($footer_product_family[0]->family)){
            $footer_product_family_1 = $footer_product_family[0]->family . ',';
        }
        if(isset($footer_product_family[1]->family) && !empty($footer_product_family[1]->family)){
            $footer_product_family_2 = $footer_product_family[1]->family. ',';
        }
        if(isset($footer_product_family[2]->family) && !empty($footer_product_family[3]->family)){
            $footer_product_family_3 = $footer_product_family[2]->family;
        }
        $footer_product_family = $footer_product_family_1.$footer_product_family_2.$footer_product_family_3;
        // return array('title' => "Shop Antique Jewelry, CZ Jewelry, Diamond Jewelry, Enamel Jewelry, Gemstones, Gold Jewelry, Jadtar Jewelry, Kundan Jewelry, One Gram Gold Jewelry, Platinum Jewelry, Silver Jewelry online from Showroom",
        //     'description' => "Buy top quality  gold antique necklace set, Gold Bangles, gold diamond bracelets, gold kundan pendant set,Diamond Rings online direct from a Manufacturer, Showroom, Wholesaler based in Amreli, &lt;State&gt;."
        // );
        return array('title' => "Buy $primary_cat,$footer_product_family online from $primary_nob in $city",
            'description' => "Buy top quality popular design 916 hallmark $footer_product_family online from $primary_cat $primary_nob in $city."
        );
    }
    public function _seoTitleDescriptionTags($keyword)
    {
        $business_name = $this->businessData->business_name;
        // $category = $this->businessData->category;
        $city = $this->businessData->city;
        $state = $this->businessData->stste;
        // $keyword = $this->businessData->bd_keyword;
        $nob = $this->businessData->business_nature;
        $primary_cat = $this->businessData->category;
        $primary_nob = $this->businessData->business_nature;
        $products = "ring, necklace, earring";
        return array('title' => "Buy $keyword online, visit our store in $city",
            'description' => "Handpicked design collection of top quality $keyword at $business_name, buy at best price online or visit our store in $city"
        );
    }
//     public function _seoTitleDescriptionMostPopular()
//     {
//         $business_name = $this->businessData->bd_business_name;
//         $city = $this->businessData->bd_city;
//         $primary_cat = $this->businessData->bd_primary_category;
//         return array('title' => "Buy The Most Popular $primary_cat in $city",
//             'description' => "Explore New Design of $primary_cat at $business_name , Discover The Latest Prices and Offers, Buy Online or Reserve and Visit Our Store in $city"
//         );
//     }
    public function _seoTitleDescriptionProfile()
    {
        $business_name = $this->businessData->business_name;
        return array('title' => "$business_name - Profile",
            'description' => "$business_name - Profile"
        );
    }

    public function _seoTitleDescriptionProductOccasionList($occasion)
    {
        $city = $this->businessData->city;
        return array('title' => "Buy quality $occasion jewelry in $city.",
            'description' => "Are you looking for the best $occasion jewelry online? Browse through our new designs, latest offers and find the nearest store in $city."
        );
    }

    public function _seoTitleDescriptionProductKaratList($karat)
    {
        $business_name = $this->businessData->business_name;
        // $category = $this->businessData->category;
        $city = $this->businessData->city;
        $state = $this->businessData->stste;
        $keyword = $this->businessData->bd_keyword;
        $nob = $this->businessData->business_nature;
        $primary_cat = $this->businessData->category;
        $primary_nob = $this->businessData->business_nature;
        $products = "ring, necklace, earring";

        return array('title' => "Buy top quality $karat jewelry in $city.",
            'description' => "Are you searching for the authentic collection of $karat jewelry online? Browse through our new designs, latest offers and find the nearest store in $city."
        );
    }

    public function _seoTitleDescriptionProductGenderList($gender)
    {
        $business_name = $this->businessData->business_name;
        // $category = $this->businessData->category;
        $city = $this->businessData->city;
        $state = $this->businessData->stste;
        $keyword = $this->businessData->bd_keyword;
        $nob = $this->businessData->business_nature;
        $primary_cat = $this->businessData->category;
        $primary_nob = $this->businessData->business_nature;
        return array('title' => "Buy quality jewelry for $gender online  in $city.",
            'description' => "Are you searching beautiful selection jewelry for $gender online? Browse through our new designs, latest offers and find the nearest store in $city."
        );
    }

//     /*
//      * Title Description for Product List Page.
//     */

    public function _seoTitleDescriptionProductCategoryList($category_title)
    {
        $category = $this->businessData->category;
        $city = $this->businessData->city;
        $nob = $this->businessData->business_nature;
        return array('title' => "Buy top quality $category_title online  in $city for best prices.",
            'description' => "Are you searching for high quality $category_title online? Browse through our popular & unique designs, latest offers and find the nearest store in $city."
        );
    }

//     /*
//          * Title Description for Product List Page.
//         */

    public function _seoTitleDescriptionProductFamilyList($product_family)
    {
        $city = $this->businessData->city;
        return array('title' => "Buy $product_family online in $city for best prices.",
            'description' => "Are you looking for top quality $product_family online? Browse through our popular & unique designs, latest offers and find the nearest store in $city."
        );
    }

    public function _seoSchemaCodeProductPFDetailsBreadcrumbList($att_name)
    {
        $url = url()->to('/');
        $data = array(
            "@context" => "http://schema.org/",
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                array(
                    "@type" => "ListItem",
                    "position" => "1",
                    "item" => array(
                        "@id" => $url,
                        "name" => "Home"
                    ),
                ),
                array(
                    "@type" => "ListItem",
                    "position" => "2",
                    "item" => array(
                        "@id" => $url . "/products",
                        "name" => "Products"
                    ),
                ),
                array(
                    "@type" => "ListItem",
                    "position" => "3",
                    "item" => array(
                        "@id" => "",
                        "name" => $att_name
                    ),
                )
            ]
        );

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

//     /*
//      * Title Description For Catalogue List page.
//     */

    public function _seoTitleDescriptionCatalogueList()
    {
        $business_name =  $this->businessData->business_name;
        $city =$this->businessData->city;
        $country =$this->businessData->country;
        $keyword =$this->businessData->bd_keyword;
        $nob =$this->businessData->business_nature;
        $primary_cat =$this->businessData->category;
        $primary_nob =$this->businessData->business_nature;
        $category =$this->businessData->category;
        $footer_product_family = Family::whereHas('products', function ($query) {
                    $query->whereNotNull('p_family');
                })->limit(3)->get();
        $footer_product_family_1 = '';
        $footer_product_family_2 = '';
        if(isset($footer_product_family[0]->bpr_product_family) && !empty($footer_product_family[0]->bpr_product_family)){
            $footer_product_family_1 = $footer_product_family[0]->bpr_product_family . ',';
        }
        if(isset($footer_product_family[1]->bpr_product_family) && !empty($footer_product_family[1]->bpr_product_family)){
            $footer_product_family_2 = $footer_product_family[1]->bpr_product_family;
        }
        $products = $footer_product_family_1.$footer_product_family_2;
        return array('title' => "Online catalog, popular $primary_cat designs by $business_name",
            'description' => "Browse online $primary_cat catalog, popular jewellery designs, exclusive collection of $products, jewelry shopping app by $business_name."
        );
        // return array('title' => "Antique Jewelry, CZ Jewelry, Diamond Jewelry, Enamel Jewelry, Gemstones, Gold Jewelry, Jadtar Jewelry, Kundan Jewelry, One Gram Gold Jewelry, Platinum Jewelry, Silver Jewelry Designs Online Catalog",
        //     'description' => "Explore latest collection of Antique Jewelry, CZ Jewelry, Diamond Jewelry, Enamel Jewelry, Gemstones, Gold Jewelry, Jadtar Jewelry, Kundan Jewelry, One Gram Gold Jewelry, Platinum Jewelry, Silver Jewelry designs online, Antique Jewelry, CZ Jewelry, Diamond Jewelry, Enamel Jewelry, Gemstones, Gold Jewelry, Jadtar Jewelry, Kundan Jewelry, One Gram Gold Jewelry, Platinum Jewelry, Silver Jewelry online catalog by $business_name."
        // );
    }

//     /*
//      * Title Description For Contact Us Page.
//     */
    public function _seoSchemaCodeCatalogueBreadcrumb($catalogue_title)
    {
        if(isset($catalogue_title) && !empty($catalogue_title)){
            $catalogue_title = $catalogue_title;
        }else{
            $catalogue_title = "Catalogue";
        }
        $url = url()->to('/');
        $data = array(
            "@context" => "http://schema.org/",
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                array(
                    "@type" => "ListItem",
                    "position" => "1",
                    "item" => array(
                        "@id" => $url,
                        "name" => "Home"
                    ),
                ),
                array(
                    "@type" => "ListItem",
                    "position" => "2",
                    "item" => array(
                        "@id" => $url . "/catalogue",
                        "name" => "Catalogue"
                    ),
                ),
                array(
                    "@type" => "ListItem",
                    "position" => "3",
                    "item" => array(
                        "@id" => '',
                        "name" => $catalogue_title
                    ),
                ),
            ]
        );

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    
    public function _seoSchemaCodeWishlist($catalogue_title)
    {
        $catalogue_title = "Wishlist";
        
        $url = url()->to('/');
        $data = array(
            "@context" => "http://schema.org/",
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                array(
                    "@type" => "ListItem",
                    "position" => "1",
                    "item" => array(
                        "@id" => $url,
                        "name" => "Home"
                    ),
                ),
                array(
                    "@type" => "ListItem",
                    "position" => "2",
                    "item" => array(
                        "@id" => $url . "/wishlist-view",
                        "name" => "Wishlist"
                    ),
                ),
                array(
                    "@type" => "ListItem",
                    "position" => "3",
                    "item" => array(
                        "@id" => '',
                        "name" => $catalogue_title
                    ),
                ),
            ]
        );

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    public function _seoSchemaCodeCartDetail()
    {
        $catalogue_title = "Cart";
        
        $url = url()->to('/');
        $data = array(
            "@context" => "http://schema.org/",
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                array(
                    "@type" => "ListItem",
                    "position" => "1",
                    "item" => array(
                        "@id" => $url,
                        "name" => "Home"
                    ),
                ),
                array(
                    "@type" => "ListItem",
                    "position" => "3",
                    "item" => array(
                        "@id" => '',
                        "name" => $catalogue_title
                    ),
                ),
            ]
        );

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }


    public function _seoTitleDescriptionContactUs($street, $area)
    {
        $business_name =  $this->businessData->business_name;
        $city =$this->businessData->city;
        $country =$this->businessData->country;
        $keyword =$this->businessData->bd_keyword;
        $nob =$this->businessData->business_nature;
        $primary_cat =$this->businessData->category;
        $primary_nob =$this->businessData->business_nature;
        $category =$this->businessData->category;
        return array('title' => "$business_name $city $primary_nob contact details",
            'description' => "Visit our online jewellery shopping website and app, walk into our $primary_cat $primary_nob on $street in $area, $city."
        );
        // return array('title' => "Madhuvan Gold Art - Antique Jewelry, CZ Jewelry, Diamond Jewelry, Enamel Jewelry, Gemstones, Gold Jewelry, Jadtar Jewelry, Kundan Jewelry, One Gram Gold Jewelry, Platinum Jewelry, Silver Jewelry Showroom Contact Details",
        //     'description' => "Find here store location,contact number and address details of Madhuvan Gold Art in Amreli.Antique Jewelry, CZ Jewelry, Diamond Jewelry, Enamel Jewelry, Gemstones, Gold Jewelry, Jadtar Jewelry, Kundan Jewelry, One Gram Gold Jewelry, Platinum Jewelry, Silver Jewelry Showroom, Amreli."
        // );
    }

//     /*
//      * Title Description For Contact Us Page.
//     */

    public function _seoTitleDescriptionCatalogueDetails($catalogue_title)
    {
        $city = $this->businessData->city;

        return array('title' => "$catalogue_title design online catalog",
            'description' => "Get quality $catalogue_title at wholesale price, browse online jewelry catalog, discover latest design trends and shop at our store in $city."
        );
        // return array('title' => "$catalogue_title design online catalog",
        //     'description' => "Get quality Gold Bangles at wholesale price, browse online jewelry catalog, discover latest design trends and shop at our store in Amreli."
        // );
    }

//     /*
//     * Title Description Product Detail Page.
//    */

    public function _seoTitleDescriptionProductDetail($product_title, $product_image)
    {
        $PRODUCT_IMAGE = url()->to('/');
        if (isset($product_image) && !empty($product_image)) {
            
            $product_image = $PRODUCT_IMAGE .'/uploads/' .$product_image;
        } else {
            //$DEFULT_PRODUCT_IMAGE = Config::get('services.website_constant.DEFULT_PRODUCT_IMAGE');
            $product_image = $PRODUCT_IMAGE.'assets/images/user/img-demo_1041.jpg';
        }

        $city = $this->businessData->city;

        $title = "Buy quality $product_title in $city";
        $description = "Get latest $product_title, view more new designs online and buy at wholesale price from our store in $city.";

        return array('title' => $title,
            'description' => $description,
            'product_image' => $product_image
        );

    }


//     public function _seoSchemaCodeProductDetailsBreadcrumbList($product_title)
//     {
//         $url = Config::get('services.website_constant.BASE_URL');
//         $data = array(
//             "@context" => "http://schema.org/",
//             "@type" => "BreadcrumbList",
//             "itemListElement" => [
//                 array(
//                     "@type" => "ListItem",
//                     "position" => "1",
//                     "item" => array(
//                         "@id" => $url,
//                         "name" => "Home"
//                     ),
//                 ),
//                 array(
//                     "@type" => "ListItem",
//                     "position" => "2",
//                     "item" => array(
//                         "@id" => $url . "products",
//                         "name" => "Products"
//                     ),
//                 ),
//                 array(
//                     "@type" => "ListItem",
//                     "position" => "3",
//                     "item" => array(
//                         "@id" => '',
//                         "name" => $product_title
//                     ),
//                 ),
//             ]
//         );

//         return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
//     }

    public function _seoSchemaCodeProductDetail($single_product,$product_image)
    {
        $url = url()->to('/');
        $city = $this->businessData->city;
        $business_name = $this->businessData->business_name;
        $title = "Buy quality $single_product->p_title in $city";
        $description = "Get latest $single_product->p_title, view more new designs online and buy at wholesale price from our store in $city.";

        if (isset($product_image) && !empty($product_image)) {
            $product_image = $url .'/uploads/' .$product_image;
        } else {
            //$DEFULT_PRODUCT_IMAGE = Config::get('services.website_constant.DEFULT_PRODUCT_IMAGE');
            $product_image = $url.'/assets/images/user/img-demo_1041.jpg';
        }

        if ($single_product->total_price($single_product->id) !== null && $single_product->total_price($single_product->id) !== '0.00') {
            $data = array(
                "@context" => "http://schema.org/",
                "@type" => "Product",
                "name" => $title,
                "image" => [
                    $product_image
                ],
                "url" => $url . '/products/' . $single_product->p_slug,
                "description" => $description,
                "sku" => $single_product->p_sku,
                "offers" => [
                    array(
                        "@type" => "Offer",
                        "priceCurrency" => '',
                        "price" => $single_product->total_price($single_product->id)
                    )
                ],
                "brand" => [
                    array(
                        "@type" => "Brand",
                        "name" => $business_name
                    )
                ]
            );
        } else {
            $data = array(
                "@context" => "http://schema.org/",
                "@type" => "Product",
                "name" => $title,
                "image" => [
                    $product_image
                ],
                "url" => $url . 'products/' . $single_product->p_slug,
                "description" => $description,
                "sku" => $single_product->p_sku,
                "brand" => [
                    array(
                        "@type" => "Brand",
                        "name" => $business_name
                    )
                ]
            );
        }


        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

//     /*
//      * ======== Home Schema Code Section ===========.
//     */

    public function _seoSchemaCodeHome()
    {

        // $BUSINESS_LOGO = Config::get('services.website_constant.BUSINESS_LOGO');
        $BASE_URL = url()->current();
        $business_name = $this->businessData->business_name;
        $category = $this->businessData->bd_all_categories;
        $city = $this->businessData->city;
        // $keyword = $this->businessData->bd_keyword;
        $description = $this->businessData->business_description;
        $nob = $this->businessData->business_nature;
        $email = $this->businessData->email;
        $mobile = $this->businessData->whatsapp_number;
        $bd_biz_logo = $BASE_URL . '/uploads/' . $this->businessData->business_logo;
        $address1 = $this->businessData->street;
        $address2 = $this->businessData->area;
        $state = $this->businessData->state;
        $pincode = $this->businessData->pincode;
        $country = $this->businessData->country;
        $latitude = isset($this->businessData->latitude) ? $this->businessData->latitude : '';
        $longitude = isset($this->businessData->longitutde) ? $this->businessData->longitutde : '';

        $data_array = array(

            "@context" => "http://www.schema.org",
            "@type" => "organization",
            "name" => $business_name,
            "description" => $description,
            "url" => $BASE_URL,
            "logo" => $bd_biz_logo,
            "email" => $email,

            "contactPoint" => array(
                "@type" => "ContactPoint",
                "telephone" => "+91-" . $mobile,
                "contactType" => "customer service"
            ),

            "location" => array(

                "@type" => "Place",
                "name" => $business_name,
                "address" => array(
                    "@type" => "PostalAddress",
                    "streetAddress" => $address1 . ',' . $address2,
                    "addressLocality" => $city,
                    "addressRegion" => $state,
                    "postalCode" => $pincode,
                    "addressCountry" => $country
                ),

                "geo" => array(
                    "@type" => "GeoCoordinates",
                    "latitude" => $latitude,
                    "longitude" => $longitude
                ),

                "sameAs" => [

                ]

            ),
        );
        return json_encode($data_array, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }


//     /*
//      *  Product list Page schema code.
//     */

    public function _seoSchemaCodeProductList()
    {
        $url = url('/');
        $data = array(
            "@context" => "http://schema.org/",
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                array(
                    "@type" => "ListItem",
                    "position" => "1",
                    "item" => array(
                        "@id" => $url,
                        "name" => "Home"
                    ),
                ),
                array(
                    "@type" => "ListItem",
                    "position" => "2",
                    "item" => array(
                        "@id" => '',
                        "name" => "Products"
                    ),
                ),
            ]
        );

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }


//     /*
//      *  Catalogue List Schema code.
//     */

//     public function _seoSchemaCodeCatalogueList()
//     {

//         $url = Config::get('services.website_constant.BASE_URL');
//         $data = array(
//             "@context" => "http://schema.org/",
//             "@type" => "BreadcrumbList",
//             "itemListElement" => [
//                 array(
//                     "@type" => "ListItem",
//                     "position" => "1",
//                     "item" => array(
//                         "@id" => $url,
//                         "name" => "Home"
//                     ),
//                 ),
//                 array(
//                     "@type" => "ListItem",
//                     "position" => "2",
//                     "item" => array(
//                         "@id" => '',
//                         "name" => "Catalogue"
//                     ),
//                 ),
//             ]
//         );

//         return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
//     }

//     /*
//      * ContactUs Schema Code.
//     */
//     public function _seoContactUsSchemaCode()
//     {

//         $url = Config::get('services.website_constant.BASE_URL');

//         $data = array(
//             "@context" => "http://schema.org/",
//             "@type" => "BreadcrumbList",
//             "itemListElement" => [
//                 array(
//                     "@type" => "ListItem",
//                     "position" => "1",
//                     "item" => array(
//                         "@id" => $url,
//                         "name" => "Home"
//                     ),
//                 ),
//                 array(
//                     "@type" => "ListItem",
//                     "position" => "2",
//                     "item" => array(
//                         "@id" => '',
//                         "name" => "Contact Us"
//                     ),
//                 ),
//             ]
//         );

//         return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
//     }


//     /*
//      * Product Details Page Schema Code.
//      */

//     public function _seoSchemaCodeProductDetails()
//     {

//         $product_details = array();
//         $data = array(
//             "@context" => "http://schema.org/",
//             "@type" => "Product",
//             "name" => "Product Name",
//             "image" => "Product Image URL",
//             "url" => "Product URL",
//             "description" => "Product Description",
//             "brand" => "",
//         );
//         if (isset($product_details[0]->bpr_price) && !empty($product_details[0]->bpr_price)) {
//             $array_offer = array(
//                 "@type" => "Offer",
//                 "priceCurrency" => $product_details[0]->cur_short_code,
//                 "price" => $product_details[0]->bpr_price,
//             );
//             $data['offers'] = $array_offer;
//         }


//         return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
//     }

//     /*Added By Karan*/
    public function _seoSchemaCodeCollectionBreadcrumb($collection_title){
        $url = url()->to('/');
        $data= array(
            "@context" => "http://schema.org/",
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                array(
                    "@type" => "ListItem",
                    "position" => "1",
                    "item" => array(
                        "@id" => $url,
                        "name" => "Home"
                    ),
                ),
                array(
                    "@type" => "ListItem",
                    "position" => "2",
                    "item" => array(
                        "@id" => $url."collection",
                        "name" => "Collection"
                    ),
                ),
                array(
                    "@type" => "ListItem",
                    "position" => "3",
                    "item" => array(
                        "@id" => '',
                        "name" => $collection_title
                    ),
                ),
            ]
        );

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function _seoTitleDescriptionCollectionDetails($collection_title){
        $business_name =  $this->businessData->business_name;
        $city =$this->businessData->city;
        $country =$this->businessData->country;
        $keyword =$this->businessData->bd_keyword;
        $nob =$this->businessData->business_nature;
        $primary_cat =$this->businessData->category;
        $primary_nob =$this->businessData->business_nature;
        $products = "ring, necklace, earring";
        $category =$this->businessData->category;

        return array('title'=>"Latest $collection_title Designs & Offers in $city.",
            'description'=>"Best place to buy $collection_title? Explore new popular Antique Jewelry designs online, discover our latest offers & buy at the best price in $country.
"
        );
    }

//     /*
//      * Title Description For CollectionList.
//     */

    public function _seoTitleDescriptionCollectionList(){
        $business_name =  $this->businessData->business_name;
        $city =$this->businessData->city;
        $country =$this->businessData->country;
        $keyword =$this->businessData->bd_keyword;
        $nob =$this->businessData->business_nature;
        $primary_cat =$this->businessData->category;
        $primary_nob =$this->businessData->business_nature;
        $products = "ring, necklace, earring";
        $category =$this->businessData->category;
        return array('title'=>"$category Design Collection Trending in $city, $country.",
            'description'=>"Looking for the best place to buy top quality $category? Discover the popular designs by $business_name in $city, $country."
        );
        // return array('title'=>"Antique Jewelry Design Collection Trending in Amreli, India",
        //     'description'=>"Looking for the best place to buy top quality Antique Jewelry? Discover the popular designs by $business_name in $city, India."
        // );
    }

//     /*
//      *  CollectionList Schema code.
//     */

    public function _seoSchemaCodeCollectionList(){

        $url = url()->to('/');
        $data = array(
            "@context" => "http://schema.org/",
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                array(
                    "@type" => "ListItem",
                    "position" => "1",
                    "item" => array(
                        "@id" => $url,
                        "name" => "Home"
                    ),
                ),
                array(
                    "@type" => "ListItem",
                    "position" => "2",
                    "item" => array(
                        "@id" => '',
                        "name" => "Collection"
                    ),
                ),
            ]
        );

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    public function _seoSchemaCodeContactus(){

        $url = url()->to('/');
        $data = array(
            "@context" => "http://schema.org/",
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                array(
                    "@type" => "ListItem",
                    "position" => "1",
                    "item" => array(
                        "@id" => $url,
                        "name" => "Home"
                    ),
                ),
                array(
                    "@type" => "ListItem",
                    "position" => "2",
                    "item" => array(
                        "@id" => $url.'/contact-us',
                        "name" => "Contact Us"
                    ),
                ),
            ]
        );

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    public function _seoSchemaCodeFAQ(){

        $url = url()->to('/');
        $data = array(
            "@context" => "http://schema.org/",
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                array(
                    "@type" => "ListItem",
                    "position" => "1",
                    "item" => array(
                        "@id" => $url,
                        "name" => "Home"
                    ),
                ),
                array(
                    "@type" => "ListItem",
                    "position" => "2",
                    "item" => array(
                        "@id" => $url.'/faq',
                        "name" => "FAQ"
                    ),
                ),
            ]
        );

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    public function _seoSchemaCodeAbout(){

        $url = url()->to('/');
        $data = array(
            "@context" => "http://schema.org/",
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                array(
                    "@type" => "ListItem",
                    "position" => "1",
                    "item" => array(
                        "@id" => $url,
                        "name" => "Home"
                    ),
                ),
                array(
                    "@type" => "ListItem",
                    "position" => "2",
                    "item" => array(
                        "@id" => $url.'/about',
                        "name" => "About"
                    ),
                ),
            ]
        );

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    public function _seoSchemaCodeTerms(){

        $url = url()->to('/');
        $data = array(
            "@context" => "http://schema.org/",
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                array(
                    "@type" => "ListItem",
                    "position" => "1",
                    "item" => array(
                        "@id" => $url,
                        "name" => "Home"
                    ),
                ),
                array(
                    "@type" => "ListItem",
                    "position" => "2",
                    "item" => array(
                        "@id" => $url.'/terms-and-condition',
                        "name" => "Terms"
                    ),
                ),
            ]
        );

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    public function _seoSchemaCodeRefund(){

        $url = url()->to('/');
        $data = array(
            "@context" => "http://schema.org/",
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                array(
                    "@type" => "ListItem",
                    "position" => "1",
                    "item" => array(
                        "@id" => $url,
                        "name" => "Home"
                    ),
                ),
                array(
                    "@type" => "ListItem",
                    "position" => "2",
                    "item" => array(
                        "@id" => $url.'/refund-policy',
                        "name" => "Refund Policy"
                    ),
                ),
            ]
        );

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    public function _seoSchemaCodeShipping(){

        $url = url()->to('/');
        $data = array(
            "@context" => "http://schema.org/",
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                array(
                    "@type" => "ListItem",
                    "position" => "1",
                    "item" => array(
                        "@id" => $url,
                        "name" => "Home"
                    ),
                ),
                array(
                    "@type" => "ListItem",
                    "position" => "2",
                    "item" => array(
                        "@id" => $url.'/Shipping Policy',
                        "name" => "Shipping Policy"
                    ),
                ),
            ]
        );

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
     public function _seoSchemaCodedesclamier(){

        $url = url()->to('/');
        $data = array(
            "@context" => "http://schema.org/",
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                array(
                    "@type" => "ListItem",
                    "position" => "1",
                    "item" => array(
                        "@id" => $url,
                        "name" => "Home"
                    ),
                ),
                array(
                    "@type" => "ListItem",
                    "position" => "2",
                    "item" => array(
                        "@id" => $url.'/disclaimer',
                        "name" => "Disclaimer"
                    ),
                ),
            ]
        );

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    public function _seoSchemaCodePrivacy(){

        $url = url()->to('/');
        $data = array(
            "@context" => "http://schema.org/",
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                array(
                    "@type" => "ListItem",
                    "position" => "1",
                    "item" => array(
                        "@id" => $url,
                        "name" => "Home"
                    ),
                ),
                array(
                    "@type" => "ListItem",
                    "position" => "2",
                    "item" => array(
                        "@id" => $url.'/privacy-policy',
                        "name" => "Privacy Policy"
                    ),
                ),
            ]
        );

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

//     /*Static Pages SEO Details*/

//     //Privacy Policy Page

    public function _seoTitleDescriptionFaqPage()
    {
        $business_name =  $this->businessData->business_name;
        $city =$this->businessData->city;
        return array('title' => "FAQ's and Help Center - $business_name , $city",
            'description' => "Visit $business_name Help Center for all your Queries and Issues. Get quick answers to all your questions."
        );
    }

    public function _seoTitleDescriptionPrivacyPolicy()
    {
        $business_name =  $this->businessData->business_name;
        $city =$this->businessData->city;
        return array('title' => "Privacy Policy - $business_name, $city",
            'description' => "Privacy Policy and Cookie Policy of $business_name"
        );
    }

    public function _seoTitleDescriptionTermsAndCondition()
    {
        $business_name =  $this->businessData->business_name;
        $city =$this->businessData->city;
        return array('title' => "Terms and Conditions - $business_name, $city",
            'description' => "Terms of Use for $business_name"
        );
    }
    public function _seoTitleDescriptionRefundPolicy(){
        $business_name =  $this->businessData->business_name;
        $city =$this->businessData->city;
        return array('title'=>"Refund Policy - $business_name, $city",
            'description'=>"Refund Policy for $business_name"
        );
    }
    public function _seoTitleDescriptionDisclaimer(){
        $business_name =  $this->businessData->business_name;
        $city =$this->businessData->city;
        return array('title'=>"Disclaimer - $business_name, $city",
            'description'=>"Disclaimer of $business_name"
        );
    }
    public function _seoTitleDescriptionAboutUs(){
        $business_name =  $this->businessData->business_name;
        $city =$this->businessData->city;
        $category =$this->businessData->category;
        $country = $this->businessData->country;
        $nob =$this->businessData->business_nature;
        return array('title'=>"$business_name a $nob of $category in $city",
            'description'=>"Buy Best Jewellery from $nob, Latest Designs of $category, Necklace, Earrings, Rings, Bracelets for Men & Women."
        );
        // return array('title'=>"Madhuvan Gold Art - Online Jewellery Shopping Store in  Amreli",
        //      'description'=>"Buy Latest Design Gold Jewlery for Men & Women in Amreli, India"
        //  );
    }
    public function _seoTitleDescriptionShippingPolicy(){
        $business_name =  $this->businessData->business_name;
        $city =$this->businessData->city;
        $category = "Gold Jewlery";
        $country = $this->businessData->country;
        return array('title'=>"Shipping Policy - $business_name, $city",
            'description'=>"Shipping Policy of $business_name"
        );
    }
//     public function _seoTitleDescriptionCommingSoon(){
//         $business_name =  $this->businessData->bd_business_name;
//         $city =$this->businessData->bd_city;
//         $category =$this->businessData->bd_primary_category;
//         return array('title'=>"Download $business_name Mobile Application - Coming Soon!",
//             'description'=>"Download $business_name, $category Online Catalog and Shopping Mobile Application"
//         );
//     }
    public function _seoTitleDescriptionMyCart(){
        $business_name =  $this->businessData->business_name;
        $city =$this->businessData->city;
        $category =$this->businessData->category;
        return array('title'=>"Your shopping cart at $business_name in $city",
            'description'=>"Check your shopping list, items you added in your cart at $business_name, buy top quality $category in $city. You need cookies enabled to use the shopping cart from your web browser's settings."
        );
        // return array('title'=>"My Shopping cart at $business_name",
        //     'description'=>"The shopping cart gives you provision to store and review your favourite products before paying for them and proceeding to checkout."
        // );
    }
    public function _seoTitleDescriptionMyWishlist(){
        $business_name =  $this->businessData->business_name;
        $city =$this->businessData->city;
        $category =$this->businessData->category;
        return array('title'=>"Your wish list at $business_name in $city",
            'description'=>"Check your favorite items you added in your wish list at $business_name, buy top quality $category in $city. You need cookies enabled to use the shopping cart from your web browser's settings."
        );
        // return array('title'=>"Buy Wishlist $business_name",
        //     'description'=>"Place your liked products in wishlist for comparing prices &amp; check for price drops. Wishlist helps you to keep a list of your buying needs."
        // );  
    }
//     public function _seoTitleDescriptionRegistrationPage(){
//         $business_name =  $this->businessData->bd_business_name;
//         $city =$this->businessData->bd_city;
//         return array('title'=>"Registration Page - $business_name,$city",
//             'description'=>"$business_name,$city - Registration Page"
//         );
//     }
    public function _seoTitleDescriptionCheckout(){
        $business_name =  $this->businessData->business_name;
        $city =$this->businessData->city;
        $country =$this->businessData->country;
        $keyword =$this->businessData->bd_keyword;
        $nob =$this->businessData->business_nature;
        $primary_cat =$this->businessData->category;
        $primary_nob =$this->businessData->business_nature;
        $products = "ring, necklace, earring";
        $category =$this->businessData->category;
        return array('title'=>"Shopping Checkout | {$business_name}",
            'description'=>"Shopping Checkout | {$business_name}"
        );
    }
}
