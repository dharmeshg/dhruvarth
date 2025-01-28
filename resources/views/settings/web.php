<?php



use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Auth\ForgotController;

use App\Http\Controllers\Backend\PasswordController;

use App\Http\Controllers\Backend\PayrollController;

use App\Http\Controllers\Backend\UserController;

use App\Http\Controllers\Backend\SettingController;

use App\Http\Controllers\Backend\ArticleController;

use App\Http\Controllers\Backend\TestimonialController;

use App\Http\Controllers\Backend\TeamController;

use App\Http\Controllers\Backend\VideoController;

use App\Http\Controllers\Frontend\RegisterController;

use App\Http\Controllers\Backend\GalleryController;

use App\Http\Controllers\Backend\MediaController;

use App\Http\Controllers\Backend\ProductsServicesController;

use App\Http\Controllers\Backend\PageController;

use App\Http\Controllers\Backend\WidgetController;

use App\Http\Controllers\Backend\MarriedController;

use App\Http\Controllers\Backend\SlidersController;

use App\Http\Controllers\Backend\MenuController;

use App\Http\Controllers\Backend\SidebarController;

use App\Http\Controllers\Frontend\PageController as FrontendPageController;

use App\Http\Controllers\Backend\ProductController;

use App\Http\Controllers\Backend\WhatsNumberController;

use App\Http\Controllers\Backend\YoutubeController;

use App\Http\Controllers\Backend\SocialLinkController;

use App\Http\Controllers\Backend\DirectionLinkController;

use App\Http\Controllers\Backend\OpeningHoursController;

use App\Http\Controllers\Backend\DeliveryZipController;

use App\Http\Controllers\Backend\PromoCodeController;

use App\Http\Controllers\Backend\CustomersController;

use App\Http\Controllers\Backend\OrdersController;

use App\Http\Controllers\Backend\NotificationController;

use App\Http\Controllers\Backend\CatalogueController;

use App\Http\Controllers\Backend\CollectionController;

use App\Http\Controllers\Backend\DailyUpdateController;

use App\Http\Controllers\Backend\PageSettingController;


use App\Http\Controllers\Frontend\OrderController;

use App\Http\Controllers\Frontend\WishlistController;







/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

|

| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider and all of them will

| be assigned to the "web" middleware group. Make something great!

|

*/





// Route::get('/', function () {

//     return redirect()->route('login');

// });



// fronted Routes
Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home')->middleware('track.visitors');

Route::post('category-product-details', [App\Http\Controllers\Frontend\HomeController::class, 'product_details'])->name('home.category.details');

// frontend Products Routes start

Route::get('/products', [App\Http\Controllers\Frontend\ProductController::class, 'all_products'])->name('front.all.products');

Route::post('/selected-products', [App\Http\Controllers\Frontend\ProductController::class, 'page_products'])->name('front.page.products');

// Route::post('/filter-product', [App\Http\Controllers\Frontend\ProductController::class, 'filter_product'])->name('front.filter.product');
Route::post('/filter-product', [App\Http\Controllers\Frontend\HomeController::class, 'filter_product'])->name('front.filter.product');


Route::get('/products/ct/{cat}/pf/{fam}', [App\Http\Controllers\Frontend\ProductController::class, 'cat_products'])->name('front.cat.fam.products');

Route::get('/products/ct/{cat}', [App\Http\Controllers\Frontend\ProductController::class, 'cat_products'])->name('front.cat.products');

Route::get('/products/ct/{cat}/gn/{gender}', [App\Http\Controllers\Frontend\ProductController::class, 'attr_products'])->name('front.gen.products');

Route::get('/products/ct/{cat}/carat/{purity}', [App\Http\Controllers\Frontend\ProductController::class, 'purity_products'])->name('front.caret.products');

Route::get('/products/{slug}', [App\Http\Controllers\Frontend\ProductController::class, 'product_detail'])->name('front.detail.products');

Route::post('/add-to-cart', [App\Http\Controllers\Frontend\ProductController::class, 'add_to_cart'])->name('front.add.cart.products');

Route::post('/update-to-cart', [App\Http\Controllers\Frontend\ProductController::class, 'update_to_cart'])->name('front.update.cart.products');

Route::post('/remove-cart', [App\Http\Controllers\Frontend\ProductController::class, 'remove_cart'])->name('front.remove.cart.products');

Route::get('/cart-view', [App\Http\Controllers\Frontend\ProductController::class, 'cart_view'])->name('front.cart.view');

Route::post('/add-to-wishlist', [App\Http\Controllers\Frontend\ProductController::class, 'add_to_wishlist'])->name('front.add.wishlist.products');

Route::get('/wishlist-view', [App\Http\Controllers\Frontend\ProductController::class, 'wishlist_view'])->name('front.wishlist.view');

Route::post('/remove-wishlist', [App\Http\Controllers\Frontend\ProductController::class, 'remove_wishlist'])->name('front.remove.wishlist.products');

Route::post('/move-to-cart', [App\Http\Controllers\Frontend\ProductController::class, 'move_to_cart'])->name('front.move.cart.products');

Route::post('/move-to-wishlist', [App\Http\Controllers\Frontend\ProductController::class, 'move_to_wishlist'])->name('front.move.wishlist.products');

Route::get('/products/pf/{fam}', [App\Http\Controllers\Frontend\ProductController::class, 'family_products'])->name('front.fam.products');

Route::get('/products/gn/{gender}', [App\Http\Controllers\Frontend\ProductController::class, 'gender_products'])->name('front.gender.products');

Route::get('/products/occassion/{occasion}', [App\Http\Controllers\Frontend\ProductController::class, 'occasion_products'])->name('front.occasion.products');

Route::get('/products/carat/{purity}', [App\Http\Controllers\Frontend\ProductController::class, 'caret_products'])->name('front.onlycaret.products');

Route::get('/products/ct/{cat}/occassion/{occasion}', [App\Http\Controllers\Frontend\ProductController::class, 'cat_occasion_products'])->name('front.cat.occasion.products');

Route::get('/tags/{slug}', [App\Http\Controllers\Frontend\ProductController::class, 'tags'])->name('front.tags');

// frontend Products Routes End

Route::get('/catalogue', [App\Http\Controllers\Frontend\HomeController::class, 'all_catalogue'])->name('front.catalogue');


Route::get('/catalogue/{id}', [App\Http\Controllers\Frontend\HomeController::class, 'catalogue_product'])->name('catalogue.product');

Route::get('/collection', [App\Http\Controllers\Frontend\HomeController::class, 'all_collection'])->name('front.collection');

Route::get('/collection/{id}', [App\Http\Controllers\Frontend\HomeController::class, 'collection_catalogue'])->name('collection.catalogues');


Route::post('/share-model', [App\Http\Controllers\Frontend\HomeController::class, 'share_model'])->name('home.share.model');

Route::get('/about', [App\Http\Controllers\Frontend\HomeController::class, 'about'])->name('front.about');

Route::get('/contact-us', [App\Http\Controllers\Frontend\HomeController::class, 'contact'])->name('home.contact_us');

// Route::post('/updateSendInquiryForm', [App\Http\Controllers\Frontend\HomeController::class, 'updateSendInquiryForm'])->name('home.updateSendInquiryForm');


// search product

Route::post('/products-search', [App\Http\Controllers\Frontend\HomeController::class, 'search_products'])->name('front.all.search_products');



// user register login start

Route::post('/user-register', [App\Http\Controllers\Frontend\RegisterController::class, 'register'])->name('user.register');

Route::post('/user-login', [App\Http\Controllers\Frontend\RegisterController::class, 'login'])->name('user.login');

Route::post('/user-logout', [App\Http\Controllers\Frontend\RegisterController::class, 'logout'])->name('user.logout');

Route::post('/changePassword', [App\Http\Controllers\Frontend\RegisterController::class, 'changePassword'])->name('user.changePassword');


// user register login end

// My Account 
Route::get('/my-account', [App\Http\Controllers\Frontend\HomeController::class, 'my_account'])->name('user.account.details');
Route::post('/forgotPassword', [App\Http\Controllers\Frontend\RegisterController::class, 'forgotPassword'])->name('user.forgetPassword');

Route::post('/updatePassword', [App\Http\Controllers\Frontend\RegisterController::class, 'updatePassword'])->name('user.updatePassword');

// subscribe email

Route::post('/scribe_email', [App\Http\Controllers\Frontend\RegisterController::class, 'scribe_email'])->name('scribe_email');



// Order details

Route::get('/order-details/{id}', [App\Http\Controllers\Frontend\OrderController::class, 'order_details'])->name('order_details');

Route::post('/order-details-store', [App\Http\Controllers\Frontend\OrderController::class, 'order_details_store'])->name('order_details_store');

Route::get('/order-checkout', [App\Http\Controllers\Frontend\OrderController::class, 'order_checkout'])->name('order_checkout');

Route::post('/fetch-cashfree-token', [App\Http\Controllers\Frontend\CashfreeController::class, 'fatchCashFreeToken'])->name('fatchCashFreeToken');

Route::post('/save-checkout-data', [App\Http\Controllers\Frontend\OrderController::class, 'save_checkout_data'])->name('save_checkout_data');

Route::post('/update-order-detail', [App\Http\Controllers\Frontend\OrderController::class, 'update_order_detail'])->name('update_order_detail');

Route::post('/cancel-order', [App\Http\Controllers\Frontend\OrderController::class, 'cancel_order'])->name('cancel_order');

Route::get('/terms-and-condition', [App\Http\Controllers\Frontend\OrderController::class, 'terms_and_condition'])->name('front.terms_and_condition');
Route::get('/privacy-policy', [App\Http\Controllers\Frontend\OrderController::class, 'privacy_policy'])->name('front.privacy_policy');
Route::get('/refund-policy', [App\Http\Controllers\Frontend\OrderController::class, 'refund_policy'])->name('front.refund_policy');
Route::get('/shipping-policy', [App\Http\Controllers\Frontend\OrderController::class, 'shipping_policy'])->name('front.shipping_policy');
Route::get('/disclaimer', [App\Http\Controllers\Frontend\OrderController::class, 'disclaimer'])->name('front.disclaimer');
Route::get('/faq', [App\Http\Controllers\Frontend\OrderController::class, 'faq'])->name('front.faq');
Route::get('/test-email', [App\Http\Controllers\Frontend\OrderController::class, 'text_mail'])->name('front.test.mail');


// Wishlist details

// Route::post('/deleteWishlist/{cart_id}', [App\Http\Controllers\Frontend\WishlistController::class, 'deleteWishlist'])->name('deleteWishlist');

// Contact us

Route::post('/updateSendInquiryForm', [App\Http\Controllers\Frontend\ContactUsController::class, 'updateSendInquiryForm'])->name('updateSendInquiryForm');



Auth::routes();

// Backend Routes



Route::prefix('admin')->group(function () {

    Route::get('login', [LoginController::class, 'index'])->name('login');

    Route::post('custom-login', [LoginController::class, 'customLogin'])->name('custom.login');

    Route::get('reset-password-link', [LoginController::class, 'send_link_reset_view'])->name('reset.pass.link.view');

    Route::post('reset-password-link-send', [LoginController::class, 'send_link_reset'])->name('reset.pass.link');

    Route::get('reset-password-store-view/{token}', [LoginController::class, 'reset_pass_store_view'])->name('reset.pass.store.view');

    Route::post('update-password', [LoginController::class, 'update_password'])->name('update.password');

    // Route::get('logout', [LoginController::class, 'userLogout'])->name('logout')->middleware('auth');



    //dashboard

    Route::get('/dashboard', [App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
    Route::post('/get-chart-data', [App\Http\Controllers\Backend\DashboardController::class, 'get_chart'])->name('get_chart_data')->middleware('auth');

    // Daily Updates routes start

    Route::get('/daily-update', [DailyUpdateController::class, 'index'])->name('daily_update.index')->middleware('auth');


    // Metal Rate
    Route::get('/metal-rate', [App\Http\Controllers\Backend\MetalRateController::class, 'index'])->name('metalrate.index')->middleware('auth');
    Route::post('metal-rate/list', [App\Http\Controllers\Backend\MetalRateController::class, 'list'])->name('metalrate.list')->middleware('auth');
    Route::post('metal-rate/save', [App\Http\Controllers\Backend\MetalRateController::class, 'save'])->name('metalrate.save')->middleware('auth');
    Route::post('metal-rate/edit', [App\Http\Controllers\Backend\MetalRateController::class, 'edit'])->name('metalrate.edit')->middleware('auth');
    Route::post('metal-rate/delete', [App\Http\Controllers\Backend\MetalRateController::class, 'delete'])->name('metalrate.delete')->middleware('auth');
    Route::post('metal-rate/pinned', [App\Http\Controllers\Backend\MetalRateController::class, 'pinned_status'])->name('metalrate.pinned')->middleware('auth');
    Route::post('metal-rate/is_status', [App\Http\Controllers\Backend\MetalRateController::class, 'is_status'])->name('metalrate.is_status')->middleware('auth');
    Route::post('metal-rate/search', [App\Http\Controllers\Backend\MetalRateController::class, 'search_metal'])->name('metalrate.search')->middleware('auth');

    // Daily Status
    Route::get('/daily-status', [App\Http\Controllers\Backend\DailyStatusController::class, 'index'])->name('daliystatus.index')->middleware('auth');
    Route::post('daily-status/save', [App\Http\Controllers\Backend\DailyStatusController::class, 'save'])->name('daliystatus.save')->middleware('auth');
    Route::get('daily-status/add', [App\Http\Controllers\Backend\DailyStatusController::class, 'add'])->name('daliystatus.add')->middleware('auth');
    Route::post('daily-status/list', [App\Http\Controllers\Backend\DailyStatusController::class, 'list'])->name('daliystatus.list')->middleware('auth');
   
    Route::get('/daily-status-edit/{id}', [App\Http\Controllers\Backend\DailyStatusController::class, 'edit'])->name('daliystatus.edit')->middleware('auth');
    Route::get('/daily-status/{id}', [App\Http\Controllers\Backend\DailyStatusController::class, 'delete'])->name('daliystatus.delete')->middleware('auth');
    Route::post('check/featured-daliy-status', [App\Http\Controllers\Backend\DailyStatusController::class, 'check_featured'])->name('daliystatus.check_featured')->middleware('auth');
    Route::post('check/pinned-chekbox-status', [App\Http\Controllers\Backend\DailyStatusController::class, 'check_pinned'])->name('daliystatus.check_pinned')->middleware('auth');
    Route::post('daily-status/search', [App\Http\Controllers\Backend\DailyStatusController::class, 'search_status'])->name('daliystatus.search')->middleware('auth');
    





    // Slider Banner
    Route::get('/slider-banner', [App\Http\Controllers\Backend\SliderBannerController::class, 'index'])->name('sliderbanner.index')->middleware('auth');
    Route::get('/add-slider-banner', [App\Http\Controllers\Backend\SliderBannerController::class, 'add'])->name('sliderbanner.add')->middleware('auth');
    Route::post('/list-slider-banner', [App\Http\Controllers\Backend\SliderBannerController::class, 'list'])->name('sliderbanner.list')->middleware('auth');
    Route::post('/save-slider-banner', [App\Http\Controllers\Backend\SliderBannerController::class, 'save'])->name('sliderbanner.save')->middleware('auth');
    Route::get('/edit-slider-banner/{id}', [App\Http\Controllers\Backend\SliderBannerController::class, 'edit'])->name('sliderbanner.edit')->middleware('auth');
    Route::get('slider-banner/delete/{id}', [App\Http\Controllers\Backend\SliderBannerController::class, 'delete'])->name('sliderbanner.delete')->middleware('auth');
    Route::post('/status-slider-banner', [App\Http\Controllers\Backend\SliderBannerController::class, 'status'])->name('adsposter.status')->middleware('auth');
    Route::post('/pinned-slider-banner', [App\Http\Controllers\Backend\SliderBannerController::class, 'pinned'])->name('adsposter.pinned')->middleware('auth');
    Route::post('/search-slider-banner', [App\Http\Controllers\Backend\SliderBannerController::class, 'search_slider_status'])->name('sliderbanner.search')->middleware('auth');
    
    // Daily Updates routes end

    // New Media routes start

    // Ads Poster

    Route::get('/ads-posters/{slug}', [App\Http\Controllers\Backend\AdsPosterController::class, 'index'])->name('adsposter.index')->middleware('auth');
    Route::get('/ads-posters/add/{sec}', [App\Http\Controllers\Backend\AdsPosterController::class, 'add'])->name('adsposter.add')->middleware('auth');

    Route::post('/save-ads-posters', [App\Http\Controllers\Backend\AdsPosterController::class, 'save'])->name('adsposter.save')->middleware('auth');
    Route::post('/list-ads-posters', [App\Http\Controllers\Backend\AdsPosterController::class, 'list'])->name('adsposter.list')->middleware('auth');
    Route::get('/edit-ads-posters/{id}', [App\Http\Controllers\Backend\AdsPosterController::class, 'edit'])->name('adsposter.edit')->middleware('auth');
    Route::get('/delete-ads-posters/{id}', [App\Http\Controllers\Backend\AdsPosterController::class, 'delete'])->name('adsposter.delete')->middleware('auth');
    Route::post('/status-ads-posters', [App\Http\Controllers\Backend\AdsPosterController::class, 'status'])->name('adsposter.status')->middleware('auth');

    // Logo Slider
    Route::get('/logo-sliders/{slug}', [App\Http\Controllers\Backend\LogoSliderController::class, 'index'])->name('logoslider.index')->middleware('auth');
    Route::get('/add-logo-sliders/{sec}', [App\Http\Controllers\Backend\LogoSliderController::class, 'add'])->name('logoslider.add')->middleware('auth');
    Route::post('/save-logo-sliders', [App\Http\Controllers\Backend\LogoSliderController::class, 'save'])->name('logoslider.save')->middleware('auth');
    Route::post('/list-logo-sliders', [App\Http\Controllers\Backend\LogoSliderController::class, 'list'])->name('logoslider.list')->middleware('auth');
    Route::get('/edit-logo-sliders/{id}', [App\Http\Controllers\Backend\LogoSliderController::class, 'edit'])->name('logoslider.edit')->middleware('auth');
    Route::get('/delete-logo-sliders/{id}', [App\Http\Controllers\Backend\LogoSliderController::class, 'delete'])->name('logoslider.delete')->middleware('auth');
    Route::post('/status-logo-sliders', [App\Http\Controllers\Backend\LogoSliderController::class, 'status'])->name('logoslider.status')->middleware('auth');

    // Pdf List

    Route::get('/pdf-list/{slug}', [App\Http\Controllers\Backend\PdfListController::class, 'index'])->name('pdflist.index')->middleware('auth');
    Route::post('/save-pdf-list', [App\Http\Controllers\Backend\PdfListController::class, 'save'])->name('pdflist.save')->middleware('auth');
    Route::post('/list-pdf-list', [App\Http\Controllers\Backend\PdfListController::class, 'list'])->name('pdflist.list')->middleware('auth');
    Route::post('/edit-pdf-list', [App\Http\Controllers\Backend\PdfListController::class, 'edit'])->name('pdflist.edit')->middleware('auth');
    Route::get('/delete-pdf-list/{id}', [App\Http\Controllers\Backend\PdfListController::class, 'delete'])->name('pdflist.delete')->middleware('auth');
    Route::post('/status-pdf-list', [App\Http\Controllers\Backend\PdfListController::class, 'status'])->name('pdflist.status')->middleware('auth');

    // Page Banner
    Route::get('/page-banner', [App\Http\Controllers\Backend\PageBannerController::class, 'index'])->name('pagebanner.index')->middleware('auth');
    Route::get('/add-page-banner/{sec}', [App\Http\Controllers\Backend\PageBannerController::class, 'add'])->name('pagebanner.add')->middleware('auth');
    Route::post('/save-page-banner', [App\Http\Controllers\Backend\PageBannerController::class, 'save'])->name('pagebanner.save')->middleware('auth');
    Route::post('/list-page-banner', [App\Http\Controllers\Backend\PageBannerController::class, 'list'])->name('pagebanner.list')->middleware('auth');
    Route::post('/edit-page-banner', [App\Http\Controllers\Backend\PageBannerController::class, 'edit'])->name('pagebanner.edit')->middleware('auth');
    Route::post('/delete-page-banner', [App\Http\Controllers\Backend\PageBannerController::class, 'delete'])->name('pagebanner.delete')->middleware('auth');
    Route::post('/status-page-banner', [App\Http\Controllers\Backend\PageBannerController::class, 'status'])->name('pagebanner.status')->middleware('auth');

    // New Media routes end

    //categories

    Route::get('/categories', [App\Http\Controllers\Backend\CategoriesController::class, 'index'])->name('categories')->middleware('auth');

    Route::post('category/save', [App\Http\Controllers\Backend\CategoriesController::class, 'save'])->name('categories.save')->middleware('auth');

    Route::get('category/delete/{id}', [App\Http\Controllers\Backend\CategoriesController::class, 'delete'])->name('category.delete')->middleware('auth');

    Route::post('category/edit', [App\Http\Controllers\Backend\CategoriesController::class, 'edit'])->name('category.edit')->middleware('auth');

    Route::post('category/list', [App\Http\Controllers\Backend\CategoriesController::class, 'list'])->name('category.list')->middleware('auth');

    Route::post('check/featured-category', [App\Http\Controllers\Backend\CategoriesController::class, 'check_featured'])->name('category.check_featured')->middleware('auth');

    Route::post('check/slug', [App\Http\Controllers\Backend\CategoriesController::class, 'check_slug'])->name('category.check_slug')->middleware('auth');

    // Families

    Route::get('/families', [App\Http\Controllers\Backend\FamilyController::class, 'index'])->name('families')->middleware('auth');

    Route::post('family/save', [App\Http\Controllers\Backend\FamilyController::class, 'save'])->name('families.save')->middleware('auth');

    Route::get('family/delete/{id}', [App\Http\Controllers\Backend\FamilyController::class, 'delete'])->name('family.delete')->middleware('auth');

    Route::post('family/edit', [App\Http\Controllers\Backend\FamilyController::class, 'edit'])->name('family.edit')->middleware('auth');

    Route::post('family/list', [App\Http\Controllers\Backend\FamilyController::class, 'list'])->name('family.list')->middleware('auth');

    Route::post('check/featured-family', [App\Http\Controllers\Backend\FamilyController::class, 'check_featured'])->name('family.check_featured')->middleware('auth');

    Route::post('family-check/slug', [App\Http\Controllers\Backend\FamilyController::class, 'check_slug'])->name('family.check_slug')->middleware('auth');

    // Products 

    Route::get('/product', [ProductController::class, 'dash_index'])->name('product_all.index')->middleware('auth');


    Route::get('/products', [ProductController::class, 'index'])->name('product.index')->middleware('auth');
    Route::get('/add-product', [ProductController::class, 'add'])->name('product.add')->middleware('auth');
    Route::post('/all-data', [ProductController::class, 'all_data'])->name('product.all.data')->middleware('auth');
    Route::post('/get-metal-rate', [ProductController::class, 'get_rate'])->name('product.get.rate')->middleware('auth');
    Route::post('/product-save', [ProductController::class, 'save'])->name('product.save')->middleware('auth');
    Route::post('/product-list', [ProductController::class, 'list'])->name('product.list')->middleware('auth');
    Route::get('/edit-product/{id}', [ProductController::class, 'edit'])->name('product.edit')->middleware('auth');
    Route::post('/product-sku-check', [ProductController::class, 'sku_check'])->name('product.sku.check')->middleware('auth');
    Route::post('/product-del-img', [ProductController::class, 'del_image'])->name('product.del.img')->middleware('auth');
    Route::get('product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete')->middleware('auth');
    Route::post('/product-status', [ProductController::class, 'status'])->name('product.status')->middleware('auth');
    Route::post('/get-deliver-data', [ProductController::class, 'get_delivery'])->name('product.get.delivery')->middleware('auth');
    Route::post('/get-deliver-zip', [ProductController::class, 'get_delivery_zip'])->name('product.get.delivery.zip')->middleware('auth');
    Route::post('/filter-product', [ProductController::class, 'filter_pro'])->name('product.filter')->middleware('auth');

    //Catalogue
    Route::get('/catalogues', [CatalogueController::class, 'index'])->name('catalogue.index')->middleware('auth');
    Route::get('/add-catalogue', [CatalogueController::class, 'add'])->name('catalogue.add')->middleware('auth');
    Route::post('/save-catalogue', [CatalogueController::class, 'save'])->name('catalogue.save')->middleware('auth');
    Route::post('/list-catalogue', [CatalogueController::class, 'list'])->name('catalogue.list')->middleware('auth');
    Route::get('/edit-catalogue/{id}', [CatalogueController::class, 'edit'])->name('catalogue.edit')->middleware('auth');
    Route::get('catalogue/delete/{id}', [CatalogueController::class, 'delete'])->name('catalogue.delete')->middleware('auth');
    Route::post('/catalogue-status', [CatalogueController::class, 'status'])->name('catalogue.status')->middleware('auth');
    Route::get('/catalogue-product-view/{slug}', [CatalogueController::class, 'different_view'])->name('catalogue.different.view')->middleware('auth');
    Route::post('/add-product-catalogue', [CatalogueController::class, 'add_product_cat'])->name('add.product.catalogue')->middleware('auth');
    Route::post('/search-product-catalogue', [CatalogueController::class, 'search_product_cat'])->name('search.product.catalogue')->middleware('auth');
    Route::post('/page-product-catalogue', [CatalogueController::class, 'page_product_cat'])->name('page.product.catalogue')->middleware('auth');
    Route::post('/filter-catalogue', [CatalogueController::class, 'filter_cat'])->name('catalogue.filter')->middleware('auth');

    // Collections
    Route::get('/collections', [CollectionController::class, 'index'])->name('collection.index')->middleware('auth');
    Route::get('/add-collection', [CollectionController::class, 'add'])->name('collection.add')->middleware('auth');
    Route::post('/save-collection', [CollectionController::class, 'save'])->name('collection.save')->middleware('auth');
    Route::post('/list-collection', [CollectionController::class, 'list'])->name('collection.list')->middleware('auth');
    Route::get('/edit-collection/{id}', [CollectionController::class, 'edit'])->name('collection.edit')->middleware('auth');
    Route::get('collection/delete/{id}', [CollectionController::class, 'delete'])->name('collection.delete')->middleware('auth');
    Route::post('/collection-status', [CollectionController::class, 'status'])->name('collection.status')->middleware('auth');
    Route::get('/collection-catalogue-view/{slug}', [CollectionController::class, 'different_view'])->name('collection.different.view')->middleware('auth');
    Route::post('/add-catalogue-collection', [CollectionController::class, 'add_catalogue_cat'])->name('add.catalogue.collection')->middleware('auth');
    Route::post('/search-catalogue-collection', [CollectionController::class, 'search_catalogue_cat'])->name('search.catalogue.collection')->middleware('auth');
    Route::post('/page-catalogue-collection', [CollectionController::class, 'page_catalogue_cat'])->name('page.catalogue.collection')->middleware('auth');
    Route::post('/filter-collection', [CollectionController::class, 'filter_cat'])->name('catalogue.filter')->middleware('auth');


    // Settings 

    Route::get('/setting', [SettingController::class, 'dash_index'])->name('setting_all.index')->middleware('auth');


    Route::get('/general-setting', [SettingController::class, 'index'])->name('setting.index')->middleware('auth');

    Route::get('/business-setting', [SettingController::class, 'business_index'])->name('business.setting.index')->middleware('auth');
    Route::post('/get-state', [SettingController::class, 'get_state'])->name('business.get_state')->middleware('auth');
    Route::post('/get-city', [SettingController::class, 'get_city'])->name('business.get_city')->middleware('auth');
    Route::post('/business_save', [SettingController::class, 'business_save'])->name('setting.business_save')->middleware('auth');
    Route::post('setting/update', [SettingController::class, 'save'])->name('setting.add')->middleware('auth');

    Route::get('/email-setting', [SettingController::class, 'email_setting'])->name('setting.email.index')->middleware('auth');

    Route::post('email-setting/update', [SettingController::class, 'email_setting_save'])->name('email.setting.add')->middleware('auth');

    // Page Setting Start

    Route::get('/page-setting', [PageSettingController::class, 'index'])->name('pagesetting.index')->middleware('auth');


    // About Us
    Route::get('/about-us', [App\Http\Controllers\Backend\AboutUsController::class, 'about_index'])->name('pagesetting.about_index')->middleware('auth');
    Route::post('/about-us/save', [App\Http\Controllers\Backend\AboutUsController::class, 'about_save'])->name('pagesetting.about_save')->middleware('auth');

    // Contact US

    Route::get('/contact-us', [App\Http\Controllers\Backend\ContacUsController::class, 'contact_index'])->name('pagesetting.contact_index')->middleware('auth');
    Route::post('/contact-us/save', [App\Http\Controllers\Backend\ContacUsController::class, 'contact_save'])->name('pagesetting.contact_save')->middleware('auth');

    // Page Setting End



// Links 

    //whats-number
    Route::get('/whats-number', [WhatsNumberController::class, 'index'])->name('whatsNumber.index')->middleware('auth');
    Route::post('whats-number/save', [WhatsNumberController::class, 'save'])->name('whatsNumber.save')->middleware('auth');
    Route::post('whatsNumber/list', [WhatsNumberController::class, 'list'])->name('whatsNumber.list')->middleware('auth');

    // youtube video

    Route::get('/youtube', [YoutubeController::class, 'index'])->name('youtube.index')->middleware('auth');
    Route::post('youtube/save', [YoutubeController::class, 'save'])->name('youtube.save')->middleware('auth');
    Route::post('youtube/list', [YoutubeController::class, 'list'])->name('youtube.list')->middleware('auth');

    // social link

    Route::get('/social-link', [SocialLinkController::class, 'index'])->name('socialLink.index')->middleware('auth');
    Route::post('social-link/save', [SocialLinkController::class, 'save'])->name('socialLink.save')->middleware('auth');
    Route::post('social-link/list', [SocialLinkController::class, 'list'])->name('socialLink.list')->middleware('auth');


    // Testimonial

    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index')->middleware('auth');
    Route::get('/testimonials-add', [TestimonialController::class, 'add'])->name('testimonials.add')->middleware('auth');
    Route::post('testimonials/store', [TestimonialController::class, 'store'])->name('testimonials.store')->middleware('auth');
    Route::post('testimonials/list', [TestimonialController::class, 'list'])->name('testimonials.list')->middleware('auth');
    Route::get('/testimonials/{id}', [TestimonialController::class, 'delete'])->name('testimonials.delete')->middleware('auth');
    Route::post('check/featured-testimonials', [TestimonialController::class, 'check_featured'])->name('testimonials.check_featured')->middleware('auth');
    Route::post('testimonials/search', [TestimonialController::class, 'search_testi_status'])->name('testimonials.search')->middleware('auth');
    Route::post('testimonials/comment', [TestimonialController::class, 'get_comment'])->name('testimonials.get_comment')->middleware('auth');

    //opening_hours

    Route::get('/opening-hours', [OpeningHoursController::class, 'index'])->name('opening_hours.index')->middleware('auth');
    Route::post('opening-hours/list', [OpeningHoursController::class, 'list'])->name('opening_hours.list')->middleware('auth');
    Route::post('opening-hours/save', [OpeningHoursController::class, 'save'])->name('opening_hours.save')->middleware('auth');
    Route::post('check/featured-hours', [OpeningHoursController::class, 'check_featured'])->name('opening_hours.check_featured')->middleware('auth');

    


     //direction_link

    Route::get('/direction-link', [DirectionLinkController::class, 'index'])->name('direction_link.index')->middleware('auth');
    Route::post('direction-link/save', [DirectionLinkController::class, 'save'])->name('direction_link.save')->middleware('auth');
    Route::post('direction-link/list', [DirectionLinkController::class, 'list'])->name('direction_link.list')->middleware('auth');

     //Delivery Zip Code

    Route::get('/delivery-zip', [DeliveryZipController::class, 'index'])->name('delivery_zip.index')->middleware('auth');
    Route::get('/add-delivery-zip', [DeliveryZipController::class, 'add'])->name('delivery_zip.add')->middleware('auth');
    Route::post('delivery-zip/save', [DeliveryZipController::class, 'save'])->name('delivery_zip.save')->middleware('auth');
    Route::post('delivery-zip/list', [DeliveryZipController::class, 'list'])->name('delivery_zip.list')->middleware('auth');
    Route::post('check/featured-delivery_zip', [DeliveryZipController::class, 'check_featured'])->name('delivery_zip.check_featured')->middleware('auth');
    Route::get('/delivery-zip/{id}', [DeliveryZipController::class, 'delete'])->name('delivery_zip.delete')->middleware('auth');



    // promo code

    Route::get('/promo-code', [PromoCodeController::class, 'index'])->name('promo_code.index')->middleware('auth');
    Route::get('/promo-code/add', [PromoCodeController::class, 'add'])->name('promo_code.add')->middleware('auth');
    Route::post('promo-code/save', [PromoCodeController::class, 'save'])->name('promo_code.save')->middleware('auth');
    Route::post('promo-code/list', [PromoCodeController::class, 'list'])->name('promo_code.list')->middleware('auth');
    Route::get('/promo-code/{id}', [PromoCodeController::class, 'delete'])->name('promo_code.delete')->middleware('auth');
    Route::post('check/featured-promo-code', [PromoCodeController::class, 'check_featured'])->name('promo_code.check_featured')->middleware('auth');
    Route::get('/promo-code-edit/{id}', [PromoCodeController::class, 'edit'])->name('promo_code.edit')->middleware('auth');




    


    //tags

    // Route::get('/tags', [App\Http\Controllers\Backend\TagsController::class, 'index'])->name('tags')->middleware('auth');

    // Route::post('tags/save', [App\Http\Controllers\Backend\TagsController::class, 'save'])->name('tags.save')->middleware('auth');

    // Route::get('tags/delete/{id}', [App\Http\Controllers\Backend\TagsController::class, 'delete'])->name('tags.delete')->middleware('auth');

    // Route::post('tags/edit', [App\Http\Controllers\Backend\TagsController::class, 'edit'])->name('tags.edit')->middleware('auth');

    // Route::post('tags/list', [App\Http\Controllers\Backend\TagsController::class, 'list'])->name('tags.list')->middleware('auth');

    // Route::post('check/featured-tags', [App\Http\Controllers\Backend\TagsController::class, 'check_featured'])->name('tags.check_featured')->middleware('auth');

    // Route::post('check/tag-slug', [App\Http\Controllers\Backend\TagsController::class, 'check_slug'])->name('tag.check_slug')->middleware('auth');





    //Media

    Route::get('/media', [MediaController::class, 'index'])->name('media.index')->middleware('auth');

    Route::get('/media-section/{sec}', [MediaController::class, 'section'])->name('media.section')->middleware('auth');

    Route::post('/media-section-store', [MediaController::class, 'section_store'])->name('media.section.store')->middleware('auth');

    Route::post('/media-section-get', [MediaController::class, 'get_section'])->name('media.section.get')->middleware('auth');

    Route::post('/media-section-delete', [MediaController::class, 'del_section'])->name('media.section.delete')->middleware('auth');


    // // Pages 

    // Route::get('/pages', [PageController::class, 'index'])->name('pages.index')->middleware('auth');

    // Route::post('/page-list', [PageController::class, 'list'])->name('page.list')->middleware('auth');

    // Route::get('/add-page', [PageController::class, 'add'])->name('pages.add')->middleware('auth');

    // Route::get('/edit-page/{id}', [PageController::class, 'edit'])->name('pages.edit')->middleware('auth');

    // Route::post('/page-save', [PageController::class, 'save'])->name('page.save')->middleware('auth');

    // Route::get('/page-delete/{id}', [PageController::class, 'delete'])->name('page.delete')->middleware('auth');

    // Route::post('check/page-slug', [PageController::class, 'check_slug'])->name('page.check_slug')->middleware('auth');



    // // Page Section Builder

    // Route::get('/page-builder-sections/{id}', [PageController::class, 'page_buider'])->name('pages.builder')->middleware('auth');

    // Route::post('page-builder-sections-store', [PageController::class, 'page_sec_store'])->name('pages.page_sec_store')->middleware('auth');

    // Route::post('page-builder-sections-edit', [PageController::class, 'page_sec_edit'])->name('pages.page_sec_edit')->middleware('auth');

    // Route::post('page-builder-sections-delete', [PageController::class, 'page_sec_delete'])->name('pages.page_sec_delete')->middleware('auth');

    // Route::post('page-builder-sections-prop-store', [PageController::class, 'page_sec_prop_store'])->name('pages.page_sec_prop_store')->middleware('auth');

    // Route::post('page-builder-sections-change-order', [PageController::class, 'page_sec_change_order'])->name('pages.page_sec_change_order')->middleware('auth');



    // // Section Widgets

    // Route::post('section-widget-store', [WidgetController::class, 'sec_widget_store'])->name('pages.sec_widget_store')->middleware('auth');

    // Route::post('section-widget-delete', [WidgetController::class, 'sec_widget_delete'])->name('pages.sec_widget_delete')->middleware('auth');

    // Route::post('section-widget-prop-store', [WidgetController::class, 'sec_widget_prop_store'])->name('pages.sec_widget_prop_store')->middleware('auth');

    // Route::post('section-widget-prop-get', [WidgetController::class, 'sec_widget_prop_get'])->name('pages.sec_widget_prop_get')->middleware('auth');

    // Route::post('section-widget-change-order', [PageController::class, 'sec_widget_update_order'])->name('pages.sec_widget_update_order')->middleware('auth');



    // Home page setting 

    Route::get('/home-page-setting', [SettingController::class, 'homepage_setting_view'])->name('setting.homepage.index')->middleware('auth');
    Route::post('/home-page-setting-store', [SettingController::class, 'homepage_setting_store'])->name('homepage_setting.store')->middleware('auth');
    Route::post('/update-section-status', [SettingController::class, 'update_sec_status'])->name('update_sec_status')->middleware('auth');
    Route::post('/update-section-order', [SettingController::class, 'update_sec_order'])->name('update_sec_order')->middleware('auth');


 // sliders

    // Route::get('/sliders', [SlidersController::class, 'index'])->name('sliders.index')->middleware('auth');

    // Route::get('/sliders-add', [SlidersController::class, 'add'])->name('sliders.add')->middleware('auth');

    // Route::post('/sliders-store', [SlidersController::class, 'store'])->name('sliders.store')->middleware('auth');

    // Route::post('/list-sliders', [SlidersController::class, 'list'])->name('list-sliders')->middleware('auth');

    // Route::get('/sliders-delete/{id}', [SlidersController::class, 'delete'])->name('sliders.delete')->middleware('auth');

    // Route::get('/sliders-edit/{id}', [SlidersController::class, 'edit'])->name('sliders.edit')->middleware('auth');

    // Route::post('/sliders-status', [SlidersController::class, 'check_status'])->name('sliders.status')->middleware('auth');


 // menu

    // Route::get('/menu', [MenuController::class, 'index'])->name('menu.index')->middleware('auth');
    // Route::post('/menu-add', [MenuController::class, 'add'])->name('menu.add')->middleware('auth');
    // Route::post('/list-menu', [MenuController::class, 'store'])->name('list-menu')->middleware('auth');
    // Route::get('/menu-delete/{id}', [MenuController::class, 'delete'])->name('menu.delete')->middleware('auth');
    // Route::post('/display-location', [MenuController::class, 'display_location'])->name('menu.display_location')->middleware('auth');
    // Route::get('/menu-edit/{id}', [MenuController::class, 'edit'])->name('menu.edit')->middleware('auth');
    // Route::post('/edit-menu', [MenuController::class, 'edit_menu'])->name('menu.edit_menu')->middleware('auth');



// Sidebar settings

    // Route::get('/sidebar-setting', [SidebarController::class, 'index'])->name('sidebar.index')->middleware('auth');
    // Route::post('/sidebar-setting-save', [SidebarController::class, 'save'])->name('sidebar.save')->middleware('auth');
    // Route::post('/sidebar-sequence-change', [SidebarController::class, 'sequence_change'])->name('sidebar.sequence')->middleware('auth');
    // Route::post('/sidebar-setting-delete', [SidebarController::class, 'delete'])->name('sidebar.delete')->middleware('auth');
    // Route::post('/sidebar-get-html', [SidebarController::class, 'get_html'])->name('sidebar.get.html')->middleware('auth');
    // Route::post('/sidebar-prop-save', [SidebarController::class, 'prop_save'])->name('sidebar.prop.save')->middleware('auth');

// Comment settings 

    // Route::get('/comment-setting', [SettingController::class, 'comment_index'])->name('comment.index')->middleware('auth');
    // Route::post('/comment-setting-save', [SettingController::class, 'comment_save'])->name('comment.save')->middleware('auth');


//Customers

   Route::get('/customers', [CustomersController::class, 'customers_index'])->name('customers.index')->middleware('auth');
   Route::post('customers/list', [CustomersController::class, 'list'])->name('customers.list')->middleware('auth');
   Route::post('customers/search', [CustomersController::class, 'search_customers'])->name('customers.search')->middleware('auth');
   Route::get('/customers/{id}', [CustomersController::class, 'edit'])->name('customers.edit')->middleware('auth');
   Route::post('customers/save', [CustomersController::class, 'save'])->name('customers.save')->middleware('auth');
   Route::get('/customers-product_list/{id}', [CustomersController::class, 'product_list'])->name('customers.product_list')->middleware('auth');
   Route::post('customers/product_details_list', [CustomersController::class, 'product_details_list'])->name('customers.product_details_list')->middleware('auth');
   Route::post('customers/product-list-search', [CustomersController::class, 'product_list_search'])->name('customers.product_list_search')->middleware('auth');
   Route::post('customers/is_status', [CustomersController::class, 'is_status'])->name('customers.is_status')->middleware('auth');
   Route::post('customers/export', [CustomersController::class, 'export'])->name('customer.export')->middleware('auth');
   


  //Orders 
   Route::get('/orders', [OrdersController::class, 'orders_index'])->name('orders.index')->middleware('auth');
   Route::post('orders/list', [OrdersController::class, 'list'])->name('orders.list')->middleware('auth');
   Route::post('orders/search', [OrdersController::class, 'search_orders'])->name('orders.search')->middleware('auth');
   Route::post('orders/export', [OrdersController::class, 'export'])->name('orders.export')->middleware('auth');
   Route::get('/orders/{id}', [OrdersController::class, 'details'])->name('orders.details')->middleware('auth');
   

  // Notification

   Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index')->middleware('auth');
   Route::post('notification/save', [NotificationController::class, 'save'])->name('notification.save')->middleware('auth');
   


   










    



     


});


// frontend routes
Route::get('/adminer', function () {
    return redirect('/adminer');
});
// Route::get('/{slug}', [FrontendPageController::class, 'index'])->name('frontend.page.index');





