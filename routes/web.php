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

use App\Http\Controllers\Backend\VariantProductController;

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

use App\Http\Controllers\Backend\BulkUploadController;

use App\Http\Controllers\Backend\AccessControlController;

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
Route::fallback(function () {
    return redirect()->route('home');
});


Route::get('/clear-config-cache', function () {
    Artisan::call('config:cache');
    return 'Config cache has clear successfully !';
});
Route::get('/clear-app-cache', function () {
    Artisan::call('cache:clear');
    return 'Application cache has clear successfully!';
});

Route::get('/queue-cron-job', [App\Http\Controllers\HomeController::class, 'queue_cron_job'])->name('queue.cron.job');

Route::post('/check-user-access', [App\Http\Controllers\Frontend\HomeController::class, 'check_user_access'])->name('front.check_user_access');

Route::middleware(['web_application_firewall', 'throttle:5000,1'])->group(function () {
// fronted Routes
    Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home')->middleware('access.control');

    Route::get('/sendtestemail', [App\Http\Controllers\Frontend\HomeController::class, 'sendtestemail'])->name('sendtestemail');

    Route::post('category-product-details', [App\Http\Controllers\Frontend\HomeController::class, 'product_details'])->name('home.category.details');
    Route::post('get_popups', [App\Http\Controllers\Frontend\HomeController::class, 'get_popups'])->name('get_popups');

    Route::post('search-product-detail', [App\Http\Controllers\Frontend\HomeController::class, 'search_productd_detail'])->name('search.product.detail');

    Route::post('add-order-note', [App\Http\Controllers\Frontend\HomeController::class, 'add_order_note'])->name('add.order.note');

    Route::post('get-promocode-data', [App\Http\Controllers\Frontend\HomeController::class, 'get_promocode_data'])->name('front.promocode.data');

    Route::get('/import-users', [App\Http\Controllers\Frontend\HomeController::class, 'import_users'])->name('import.users');

// frontend Products Routes start

    Route::get('/products', [App\Http\Controllers\Frontend\ProductController::class, 'all_products'])->name('front.all.products')->middleware('access.control');

    Route::post('/selected-products', [App\Http\Controllers\Frontend\ProductController::class, 'page_products'])->name('front.page.products')->middleware('access.control');

    Route::post('/filter-product', [App\Http\Controllers\Frontend\HomeController::class, 'filter_product'])->name('front.filter.product');

    Route::get('/products/{slug}', [App\Http\Controllers\Frontend\ProductController::class, 'product_detail'])->name('front.detail.products')->middleware('access.control');

    Route::get('/products/ct/{cat}/pf/{fam}', [App\Http\Controllers\Frontend\ProductController::class, 'cat_products'])->name('front.cat.fam.products')->middleware('access.control');

    Route::get('/products/ct/{cat}', [App\Http\Controllers\Frontend\ProductController::class, 'cat_products'])->name('front.cat.products')->middleware('access.control');

    Route::get('/products/ct/{cat}/gn/{gender}', [App\Http\Controllers\Frontend\ProductController::class, 'attr_products'])->name('front.gen.products')->middleware('access.control');

    Route::get('/products/ct/{cat}/carat/{purity}', [App\Http\Controllers\Frontend\ProductController::class, 'purity_products'])->name('front.caret.products')->middleware('access.control');

    Route::post('/add-to-cart', [App\Http\Controllers\Frontend\ProductController::class, 'add_to_cart'])->name('front.add.cart.products');

    Route::post('/update-to-cart', [App\Http\Controllers\Frontend\ProductController::class, 'update_to_cart'])->name('front.update.cart.products');

    Route::post('/remove-cart', [App\Http\Controllers\Frontend\ProductController::class, 'remove_cart'])->name('front.remove.cart.products');

    Route::get('/cart-view', [App\Http\Controllers\Frontend\ProductController::class, 'cart_view'])->name('front.cart.view')->middleware('access.control');

    Route::post('/add-to-wishlist', [App\Http\Controllers\Frontend\ProductController::class, 'add_to_wishlist'])->name('front.add.wishlist.products');

    Route::get('/wishlist-view', [App\Http\Controllers\Frontend\ProductController::class, 'wishlist_view'])->name('front.wishlist.view')->middleware('access.control');

    Route::post('/remove-wishlist', [App\Http\Controllers\Frontend\ProductController::class, 'remove_wishlist'])->name('front.remove.wishlist.products');

    Route::post('/move-to-cart', [App\Http\Controllers\Frontend\ProductController::class, 'move_to_cart'])->name('front.move.cart.products');

    Route::post('/move-to-wishlist', [App\Http\Controllers\Frontend\ProductController::class, 'move_to_wishlist'])->name('front.move.wishlist.products');

    Route::get('/products/pf/{fam}', [App\Http\Controllers\Frontend\ProductController::class, 'family_products'])->name('front.fam.products')->middleware('access.control');

    Route::get('/products/gn/{gender}', [App\Http\Controllers\Frontend\ProductController::class, 'gender_products'])->name('front.gender.products')->middleware('access.control');

    Route::get('/products/occassion/{occasion}', [App\Http\Controllers\Frontend\ProductController::class, 'occasion_products'])->name('front.occasion.products')->middleware('access.control');

    Route::get('/products/carat/{purity}', [App\Http\Controllers\Frontend\ProductController::class, 'caret_products'])->name('front.onlycaret.products')->middleware('access.control');

    Route::get('/products/ct/{cat}/occassion/{occasion}', [App\Http\Controllers\Frontend\ProductController::class, 'cat_occasion_products'])->name('front.cat.occasion.products')->middleware('access.control');

    Route::get('/tags/{slug}', [App\Http\Controllers\Frontend\ProductController::class, 'tags'])->name('front.tags')->middleware('access.control');

    Route::post('/variants-fetch', [App\Http\Controllers\Frontend\ProductController::class, 'fetch_variant'])->name('front.fetch.variant');

// frontend Products Routes End

    Route::get('/catalogue', [App\Http\Controllers\Frontend\HomeController::class, 'all_catalogue'])->name('front.catalogue')->middleware('access.control');

    Route::post('/filter-catalogue', [App\Http\Controllers\Frontend\HomeController::class, 'filter_catalogue'])->name('front.filter.catalogue');

    Route::get('/catalogue/{id}', [App\Http\Controllers\Frontend\HomeController::class, 'catalogue_product'])->name('catalogue.product')->middleware('access.control');

    Route::get('/collection', [App\Http\Controllers\Frontend\HomeController::class, 'all_collection'])->name('front.collection')->middleware('access.control');

    Route::get('/collection/{id}', [App\Http\Controllers\Frontend\HomeController::class, 'collection_catalogue'])->name('collection.catalogues')->middleware('access.control');


    Route::post('/share-model', [App\Http\Controllers\Frontend\HomeController::class, 'share_model'])->name('home.share.model');

    Route::get('/about', [App\Http\Controllers\Frontend\HomeController::class, 'about'])->name('front.about')->middleware('access.control');


    Route::get('/contact-us', [App\Http\Controllers\Frontend\HomeController::class, 'contact'])->name('home.contact_us')->middleware('access.control');

// Route::post('/updateSendInquiryForm', [App\Http\Controllers\Frontend\HomeController::class, 'updateSendInquiryForm'])->name('home.updateSendInquiryForm');


// search product

    Route::post('/products-search', [App\Http\Controllers\Frontend\HomeController::class, 'search_products'])->name('front.all.search_products');

// user register login start

    Route::post('/user-register', [App\Http\Controllers\Frontend\RegisterController::class, 'register'])->name('user.register');
    Route::post('/sentEmailVerificationCode', [App\Http\Controllers\Frontend\RegisterController::class, 'sentEmailVerificationCode'])->name('user.sendregverificationCode');


    Route::post('/user-login', [App\Http\Controllers\Frontend\RegisterController::class, 'login'])->name('user.login');

    Route::post('/user-logout', [App\Http\Controllers\Frontend\RegisterController::class, 'logout'])->name('user.logout');

    Route::post('/changePassword', [App\Http\Controllers\Frontend\RegisterController::class, 'changePassword'])->name('user.changePassword');


// user register login end

// My Account
    Route::get('/my-account', [App\Http\Controllers\Frontend\HomeController::class, 'my_account'])->name('user.account.details')->middleware(['access.control', 'customer']);
    Route::post('/forgotPassword', [App\Http\Controllers\Frontend\RegisterController::class, 'forgotPassword'])->name('user.forgetPassword');

    Route::post('/updatePassword', [App\Http\Controllers\Frontend\RegisterController::class, 'updatePassword'])->name('user.updatePassword');

// subscribe email

    Route::post('/scribe_email', [App\Http\Controllers\Frontend\RegisterController::class, 'scribe_email'])->name('scribe_email');

// Order details
    Route::get('/order-details/{id}', [App\Http\Controllers\Frontend\OrderController::class, 'order_details'])->name('order_details')->middleware(['access.control', 'customer']);

    Route::post('/order-details-store', [App\Http\Controllers\Frontend\OrderController::class, 'order_details_store'])->name('order_details_store')->middleware(['access.control', 'customer']);

    Route::get('/order-checkout', [App\Http\Controllers\Frontend\OrderController::class, 'order_checkout'])->name('order_checkout')->middleware(['access.control', 'customer']);

    Route::post('/fetch-razorpay-id', [App\Http\Controllers\Frontend\OrderController::class, 'fetchrazorpayid'])->name('fetchrazorid');

    Route::post('/fetch-cashfree-token', [App\Http\Controllers\Frontend\CashfreeController::class, 'fatchCashFreeToken'])->name('fatchCashFreeToken');

    Route::post('/save-checkout-data', [App\Http\Controllers\Frontend\OrderController::class, 'save_checkout_data'])->name('save_checkout_data')->middleware(['access.control', 'customer']);

    Route::post('/update-order-detail', [App\Http\Controllers\Frontend\OrderController::class, 'update_order_detail'])->name('update_order_detail')->middleware(['access.control', 'customer']);

    Route::post('/cancel-order', [App\Http\Controllers\Frontend\OrderController::class, 'cancel_order'])->name('cancel_order')->middleware(['access.control', 'customer']);

    Route::get('/terms-and-condition', [App\Http\Controllers\Frontend\OrderController::class, 'terms_and_condition'])->name('front.terms_and_condition')->middleware('access.control');
    Route::get('/privacy-policy', [App\Http\Controllers\Frontend\OrderController::class, 'privacy_policy'])->name('front.privacy_policy')->middleware('access.control');
    Route::get('/refund-policy', [App\Http\Controllers\Frontend\OrderController::class, 'refund_policy'])->name('front.refund_policy')->middleware('access.control');
    Route::get('/shipping-policy', [App\Http\Controllers\Frontend\OrderController::class, 'shipping_policy'])->name('front.shipping_policy')->middleware('access.control');
    Route::get('/disclaimer', [App\Http\Controllers\Frontend\OrderController::class, 'disclaimer'])->name('front.disclaimer')->middleware('access.control');
    Route::get('/faq', [App\Http\Controllers\Frontend\OrderController::class, 'faq'])->name('front.faq')->middleware('access.control');
    Route::get('/test-email', [App\Http\Controllers\Frontend\OrderController::class, 'text_mail'])->name('front.test.mail');

// Front Promo Codes Routes Start
    Route::post('/manually-apply-promocode', [App\Http\Controllers\Frontend\HomeController::class, 'apply_promocode'])->name('manually_apply_promocode')->middleware(['access.control', 'customer']);
    Route::post('/store-promocode-session', [App\Http\Controllers\Frontend\HomeController::class, 'store_promocode_session'])->name('store_promocode_session')->middleware(['customer']);
// Front Promo Codes Routes End
// Wishlist details

// Route::post('/deleteWishlist/{cart_id}', [App\Http\Controllers\Frontend\WishlistController::class, 'deleteWishlist'])->name('deleteWishlist');

// Contact us

    Route::post('/updateSendInquiryForm', [App\Http\Controllers\Frontend\ContactUsController::class, 'updateSendInquiryForm'])->name('updateSendInquiryForm');

    Route::post('/pincode-check', [App\Http\Controllers\Frontend\HomeController::class, 'pincode_check'])->name('front.pincode.check');

    Route::post('/pincode-checkout-check', [App\Http\Controllers\Frontend\HomeController::class, 'pincode_checkout_check'])->name('front.pincode.checkout');

// XML Routes

    Route::get('/catalogue-sitemap.xml', [App\Http\Controllers\HomeController::class, 'catalogue_sitemap_xml'])->name('front.catalogue.xml')->middleware('access.control');

    Route::get('/collection-sitemap.xml', [App\Http\Controllers\HomeController::class, 'collection_sitemap_xml'])->name('front.collection.xml')->middleware('access.control');

    Route::get('/product-sitemap.xml', [App\Http\Controllers\HomeController::class, 'product_sitemap_xml'])->name('front.product.xml')->middleware('access.control');

    Route::get('/product-filter-sitemap.xml', [App\Http\Controllers\HomeController::class, 'productfilter_sitemap_xml'])->name('front.productfilter.xml')->middleware('access.control');

    Route::get('/rss', [App\Http\Controllers\HomeController::class, 'download_rss_xml'])->name('download_rss_xml')->middleware('access.control');

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

        // Diamond Rate
        Route::get('/diamond-rate', [App\Http\Controllers\Backend\DiamondRateController::class, 'index'])->name('diamondrate.index')->middleware('auth');
        Route::post('diamond-rate/list', [App\Http\Controllers\Backend\DiamondRateController::class, 'list'])->name('diamondrate.list')->middleware('auth');
        Route::post('diamond-rate/save', [App\Http\Controllers\Backend\DiamondRateController::class, 'save'])->name('diamondrate.save')->middleware('auth');
        Route::post('diamond-rate/edit', [App\Http\Controllers\Backend\DiamondRateController::class, 'edit'])->name('diamondrate.edit')->middleware('auth');
        Route::post('diamond-rate/delete', [App\Http\Controllers\Backend\DiamondRateController::class, 'delete'])->name('diamondrate.delete')->middleware('auth');
        Route::post('diamond-rate/pinned', [App\Http\Controllers\Backend\DiamondRateController::class, 'pinned_status'])->name('diamondrate.pinned')->middleware('auth');
        Route::post('diamond-rate/is_status', [App\Http\Controllers\Backend\DiamondRateController::class, 'is_status'])->name('diamondrate.is_status')->middleware('auth');
        Route::post('diamond-rate/search', [App\Http\Controllers\Backend\DiamondRateController::class, 'search_diamond'])->name('diamondrate.search')->middleware('auth');

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

        // Products

        Route::get('/product', [ProductController::class, 'dash_index'])->name('product_all.index')->middleware('auth');
        Route::get('/products', [ProductController::class, 'index'])->name('product.index')->middleware('auth');
        Route::get('/quickadd-product', [ProductController::class, 'quickadd'])->name('product.quickadd')->middleware('auth');
        Route::get('/add-product', [ProductController::class, 'add'])->name('product.add')->middleware('auth');
        Route::post('/all-data', [ProductController::class, 'all_data'])->name('product.all.data')->middleware('auth');
        Route::post('/get-metal-rate', [ProductController::class, 'get_rate'])->name('product.get.rate')->middleware('auth');
        Route::post('/product-quicksave', [ProductController::class, 'save'])->name('product.quicksave')->middleware('auth');
        Route::post('/product-save', [ProductController::class, 'save'])->name('product.save')->middleware('auth');
        Route::post('/product-list', [ProductController::class, 'list'])->name('product.list')->middleware('auth');
        Route::get('/edit-product/{id}/{slug}', [ProductController::class, 'edit'])->name('product.edit')->middleware('auth');
        Route::post('/product-sku-check', [ProductController::class, 'sku_check'])->name('product.sku.check')->middleware('auth');
        Route::post('/product-del-img', [ProductController::class, 'del_image'])->name('product.del.img')->middleware('auth');
        Route::get('product/delete/{id}/{slug}', [ProductController::class, 'delete'])->name('product.delete')->middleware('auth');
        Route::post('/product-status', [ProductController::class, 'status'])->name('product.status')->middleware('auth');
        Route::post('/public-status', [ProductController::class, 'update_public'])->name('product.public.status')->middleware('auth');
        Route::post('/get-deliver-data', [ProductController::class, 'get_delivery'])->name('product.get.delivery')->middleware('auth');
        Route::post('/get-deliver-city', [ProductController::class, 'get_delivery_city'])->name('product.get.delivery.city')->middleware('auth');
        Route::post('/get-deliver-zip', [ProductController::class, 'get_delivery_zip'])->name('product.get.delivery.zip')->middleware('auth');
        Route::post('/filter-product', [ProductController::class, 'filter_pro'])->name('product.filter')->middleware('auth');
        Route::post('/selected-data', [ProductController::class, 'selected_data'])->name('product.selected.data')->middleware('auth');
        Route::post('/get-diamond-rate', [ProductController::class, 'diamond_rate'])->name('product.diamond.rate')->middleware('auth');
        Route::post('/get-families', [ProductController::class, 'get_family'])->name('product.get.family')->middleware('auth');
        Route::post('/get-tags', [ProductController::class, 'get_tag'])->name('product.get.tag')->middleware('auth');
        Route::post('/get-variant-html', [ProductController::class, 'get_variant_html'])->name('product.get.variant.html')->middleware('auth');
        Route::post('/store-product-vairants', [ProductController::class, 'store_variants'])->name('product.store.variant')->middleware('auth');
        Route::post('/download-xml', [ProductController::class, 'download_xml'])->name('product.download.xml')->middleware('auth');
        Route::post('/check-variant-exists', [ProductController::class, 'check_variant_exists'])->name('product.check_variant_exists')->middleware('auth');

        // Variants
        Route::get('/variants', [VariantProductController::class, 'index'])->name('variant.index')->middleware('auth');
        Route::post('/variant-list', [VariantProductController::class, 'list'])->name('variant.list')->middleware('auth');
        Route::get('variant/remove/{id}/{slug}', [VariantProductController::class, 'remove_variant'])->name('product.remove.variant')->middleware('auth');
        Route::post('/edit-attribute', [VariantProductController::class, 'edit_variant'])->name('variant.edit.attribute')->middleware('auth');
        Route::post('/update-attribute', [VariantProductController::class, 'update_variant'])->name('variant.update.attribute')->middleware('auth');

        // Bulk Upload
        Route::get('/bulk-upload-index', [BulkUploadController::class, 'dashboard'])->name('bulk.upload.dashboard')->middleware('auth');
        Route::get('/bulk-product-upload', [BulkUploadController::class, 'index'])->name('bulk.product.upload')->middleware('auth');
        Route::post('/bulk-attr-download', [BulkUploadController::class, 'attribute_download'])->name('bulk.attr.download')->middleware('auth');
        Route::post('/bulk-sample-download', [BulkUploadController::class, 'sample_download'])->name('bulk.sample.download')->middleware('auth');
        Route::post('/bulk-sample-variant-download', [BulkUploadController::class, 'sample_variant_download'])->name('bulk.sample.variant.download')->middleware('auth');
        Route::post('/bulk-product-store', [BulkUploadController::class, 'store'])->name('bulk.product.store')->middleware('auth');
        Route::post('/bulk-product-file-list', [BulkUploadController::class, 'file_list'])->name('bulk.product.file.list')->middleware('auth');
        Route::post('/publish-product-file', [BulkUploadController::class, 'publish_product'])->name('publish.product.file')->middleware('auth');
        Route::get('/bulk-product-image-upload', [BulkUploadController::class, 'image_index'])->name('bulk.product.image.upload')->middleware('auth');
        Route::post('/bulk-delete-product-image-upload', [BulkUploadController::class, 'bulkDeleteProductImage'])->name('bulk-delete-product-image-upload')->middleware('auth');
        Route::post('/bulk-product-image-store', [BulkUploadController::class, 'image_store'])->name('bulk.product.image.store')->middleware('auth');
        Route::post('/bulk-product-image-list', [BulkUploadController::class, 'image_list'])->name('bulk.product.image.list')->middleware('auth');
        Route::post('/bulk-product-image-download', [BulkUploadController::class, 'image_list_download'])->name('bulk.product.image.list.download')->middleware('auth');
        Route::get('/bulk-product-image-delete/{id}/{type}', [BulkUploadController::class, 'image_list_delete'])->name('bulk.product.image.list.delete')->middleware('auth');
        Route::get('/bulk-variant-upload', [BulkUploadController::class, 'variant_index'])->name('bulk.variant.upload')->middleware('auth');
        Route::post('/bulk-variant-store', [BulkUploadController::class, 'variant_store'])->name('bulk.variant.store')->middleware('auth');
        Route::post('/bulk-variant-file-list', [BulkUploadController::class, 'variant_file_list'])->name('bulk.variant.file.list')->middleware('auth');
        Route::post('/publish-variant-file', [BulkUploadController::class, 'publish_variant'])->name('variant.product.file')->middleware('auth');
        Route::get('/bulk-video-upload', [BulkUploadController::class, 'video_index'])->name('bulk.video.upload')->middleware('auth');
        Route::post('/bulk-product-video-store', [BulkUploadController::class, 'video_store'])->name('bulk.product.video.store')->middleware('auth');
        Route::post('/bulk-product-video-list', [BulkUploadController::class, 'video_list'])->name('bulk.product.video.list')->middleware('auth');
        Route::post('/bulk-product-video-download', [BulkUploadController::class, 'video_download'])->name('bulk.product.video.download')->middleware('auth');
        Route::get('/bulk-product-video-delete/{id}', [BulkUploadController::class, 'video_delete'])->name('bulk.product.video.list.delete')->middleware('auth');
        Route::get('/bulk-certificate-upload', [BulkUploadController::class, 'certificate_index'])->name('bulk.certificate.upload')->middleware('auth');
        Route::post('/bulk-product-certificate-store', [BulkUploadController::class, 'certificate_store'])->name('bulk.product.certificate.store')->middleware('auth');
        Route::post('/bulk-product-certificate-list', [BulkUploadController::class, 'certificate_list'])->name('bulk.product.certificate.list')->middleware('auth');
        Route::post('/bulk-product-certificate-download', [BulkUploadController::class, 'certificate_download'])->name('bulk.product.certificate.download')->middleware('auth');
        Route::get('/bulk-product-certificate-delete/{id}', [BulkUploadController::class, 'certificate_delete'])->name('bulk.product.certificate.list.delete')->middleware('auth');

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
        Route::post('/fetch-family', [CatalogueController::class, 'fetch_family'])->name('catalogue.fetch.family')->middleware('auth');
        Route::post('/show-count-cat', [CatalogueController::class, 'show_count_cat'])->name('catalogue.show_count_cat')->middleware('auth');

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
        Route::post('/filter-collection', [CollectionController::class, 'filter_cat'])->name('collection.filter')->middleware('auth');
        Route::post('/show-count-coll', [CollectionController::class, 'show_count_cat'])->name('collection.show_count_cat')->middleware('auth');

        // Settings

        Route::get('/setting', [SettingController::class, 'dash_index'])->name('setting_all.index')->middleware('auth');

        Route::get('/global-settings', [SettingController::class, 'global_settings'])->name('global_settings.index')->middleware('auth');

        // Route::get('/page-settings', [SettingController::class, 'page_settings'])->name('page_settings.index')->middleware('auth');


        Route::get('/general-setting', [SettingController::class, 'index'])->name('setting.index')->middleware('auth');

        Route::get('/business-setting', [SettingController::class, 'business_index'])->name('business.setting.index')->middleware('auth');
        Route::post('/get-state', [SettingController::class, 'get_state'])->name('business.get_state');
        Route::post('/get-city', [SettingController::class, 'get_city'])->name('business.get_city');
        Route::post('/business_save', [SettingController::class, 'business_save'])->name('setting.business_save')->middleware('auth');
        Route::post('setting/update', [SettingController::class, 'save'])->name('setting.add')->middleware('auth');

        Route::get('/email-setting', [SettingController::class, 'email_setting'])->name('setting.email.index')->middleware('auth');

        Route::post('email-setting/update', [SettingController::class, 'email_setting_save'])->name('email.setting.add')->middleware('auth');
        Route::get('/buy_with_confidence', [SettingController::class, 'buy_with_confidence'])->name('settings.buy-with-confidence')->middleware('auth');
        Route::post('/buy_with_confidence-save', [SettingController::class, 'buy_with_confidence_save'])->name('buy-with-confidence.save')->middleware('auth');
        Route::get('/payment-option', [SettingController::class, 'payment'])->name('settings.payment-option')->middleware('auth');
        Route::post('/payment-option-save', [SettingController::class, 'payment_save'])->name('settings.payment-option.save')->middleware('auth');
        // Page Setting Start
        Route::get('/page-setting', [PageSettingController::class, 'index'])->name('pagesetting.index')->middleware('auth');
        // Reegistration setting
        Route::get('/registration-setting', [SettingController::class, 'registration_index'])->name('registration.setting.index')->middleware('auth');
        Route::post('/update-fields-status', [SettingController::class, 'registration_update'])->name('registration.setting.update')->middleware('auth');
        // About Us
        Route::get('/about-us', [App\Http\Controllers\Backend\AboutUsController::class, 'about_index'])->name('pagesetting.about_index')->middleware('auth');
        Route::post('/about-us/save', [App\Http\Controllers\Backend\AboutUsController::class, 'about_save'])->name('pagesetting.about_save')->middleware('auth');
        Route::get('/taxes', [App\Http\Controllers\Backend\AboutUsController::class, 'taxes_view'])->name('setting.taxes')->middleware('auth');
        Route::post('/taxes-save', [App\Http\Controllers\Backend\AboutUsController::class, 'taxes_save'])->name('setting.taxes.save')->middleware('auth');
        // Contact US

        Route::get('/contact-us', [App\Http\Controllers\Backend\ContacUsController::class, 'contact_index'])->name('pagesetting.contact_index')->middleware('auth');
        Route::post('/contact-us/save', [App\Http\Controllers\Backend\ContacUsController::class, 'contact_save'])->name('pagesetting.contact_save')->middleware('auth');

        // Page Setting End


        // Testimonial
        Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index')->middleware('auth');
        Route::get('/testimonials-add', [TestimonialController::class, 'add'])->name('testimonials.add')->middleware('auth');
        Route::get('/edit-testimonial/{id}', [TestimonialController::class, 'edit'])->name('testimonials.edit')->middleware('auth');
        Route::post('/update-testimonial/{id}', [TestimonialController::class, 'update'])->name('testimonials.update')->middleware('auth');;
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
        Route::get('/edit-delivery-zip/{country}/{state}/{city}', [DeliveryZipController::class, 'edit'])->name('delivery_zip.edit')->middleware('auth');
        Route::get('/edit-delivery-zip-by-state/{country}/{state}/{city}/{zip}', [DeliveryZipController::class, 'editZip'])->name('delivery_zip.state.edit')->middleware('auth');
        Route::post('delivery-zip/save', [DeliveryZipController::class, 'save'])->name('delivery_zip.save')->middleware('auth');
        Route::post('delivery-zip-by-state/update/{zip}', [DeliveryZipController::class, 'update'])->name('delivery_zip.update')->middleware('auth');
        Route::post('delivery-zip/list', [DeliveryZipController::class, 'list'])->name('delivery_zip.list')->middleware('auth');
        Route::post('check/featured-delivery_zip', [DeliveryZipController::class, 'check_featured'])->name('delivery_zip.check_featured')->middleware('auth');
        Route::get('/delivery-delete-zip/{country}/{state}/{city}', [DeliveryZipController::class, 'delete_by_state'])->name('delivery_zip.delete.state')->middleware('auth');
        Route::get('/delivery-zip/{id}', [DeliveryZipController::class, 'delete'])->name('delivery_zip.delete')->middleware('auth');
        Route::get('/delivery-zip-by-state/{state}/{city}', [DeliveryZipController::class, 'list_by_state'])->name('delivery_zip.state')->middleware('auth');
        Route::post('delivery-zip-by-state/list', [DeliveryZipController::class, 'state_list'])->name('delivery_zip.list.state')->middleware('auth');

        Route::get('delivery-option', [DeliveryZipController::class, 'delivery_option'])->name('delivery_option.index')->middleware('auth');
        Route::post('delivery-option-save', [DeliveryZipController::class, 'delivery_option_save'])->name('delivery_option.save')->middleware('auth');
        Route::post('/get-deliver-data-global', [DeliveryZipController::class, 'get_delivery_global'])->name('global.get.delivery')->middleware('auth');

        // promo code
        Route::get('/promo-code-index', [PromoCodeController::class, 'dashboard'])->name('promo_code.dashboard')->middleware('auth');
        Route::get('/promo-code', [PromoCodeController::class, 'index'])->name('promo_code.index')->middleware('auth');
        Route::get('/promo-code/add', [PromoCodeController::class, 'add'])->name('promo_code.add')->middleware('auth');
        Route::post('promo-code/save', [PromoCodeController::class, 'save'])->name('promo_code.save')->middleware('auth');
        Route::post('promo-code/list', [PromoCodeController::class, 'list'])->name('promo_code.list')->middleware('auth');
        Route::get('/promo-code/{id}', [PromoCodeController::class, 'delete'])->name('promo_code.delete')->middleware('auth');
        Route::post('check/featured-promo-code', [PromoCodeController::class, 'check_featured'])->name('promo_code.check_featured')->middleware('auth');
        Route::get('/promo-code-edit/{id}', [PromoCodeController::class, 'edit'])->name('promo_code.edit')->middleware('auth');
        Route::post('check/existing-promo-code', [PromoCodeController::class, 'check_existing'])->name('promo_code.check_existing')->middleware('auth');
        Route::post('/promo-code/file-upload', [PromoCodeController::class, 'file_store'])->name('promo_code.file_store')->middleware('auth');
        Route::post('/promo-code/search-product', [PromoCodeController::class, 'search_product'])->name('promo_code.search_product')->middleware('auth');
        Route::get('/promo-code-used/{code}', [PromoCodeController::class, 'used_promocode'])->name('promo_code.used')->middleware('auth');
        Route::post('/promo-code-used/list', [PromoCodeController::class, 'used_promocode_list'])->name('promo_code.used.list')->middleware('auth');
        Route::post('/downoload-categories', [PromoCodeController::class, 'download_categories'])->name('promo_code.cats.download')->middleware('auth');

        //Media

        Route::get('/media', [MediaController::class, 'index'])->name('media.index')->middleware('auth');
        Route::get('/media-section/{sec}', [MediaController::class, 'section'])->name('media.section')->middleware('auth');
        Route::post('/media-section-store', [MediaController::class, 'section_store'])->name('media.section.store')->middleware('auth');
        Route::post('/media-section-get', [MediaController::class, 'get_section'])->name('media.section.get')->middleware('auth');
        Route::post('/media-section-delete', [MediaController::class, 'del_section'])->name('media.section.delete')->middleware('auth');

        // Home page setting

        Route::get('/home-page-setting', [SettingController::class, 'homepage_setting_view'])->name('setting.homepage.index')->middleware('auth');
        Route::post('/home-page-setting-store', [SettingController::class, 'homepage_setting_store'])->name('homepage_setting.store')->middleware('auth');
        Route::post('/update-section-status', [SettingController::class, 'update_sec_status'])->name('update_sec_status')->middleware('auth');
        Route::post('/update-section-status-title', [SettingController::class, 'update_sec_status_title'])->name('update_sec_status_title')->middleware('auth');
        Route::post('/update-section-order', [SettingController::class, 'update_sec_order'])->name('update_sec_order')->middleware('auth');

        //Customers
        Route::get('/customers', [CustomersController::class, 'customers_index'])->name('customers.index')->middleware('auth');
        Route::post('customers/list', [CustomersController::class, 'list'])->name('customers.list')->middleware('auth');
        Route::post('customers/search', [CustomersController::class, 'search_customers'])->name('customers.search')->middleware('auth');
        Route::get('/add-customer', [CustomersController::class, 'add'])->name('customers.add')->middleware('auth');
        Route::get('/edit-customer/{id}', [CustomersController::class, 'edit'])->name('customers.edit')->middleware('auth');
        Route::get('/customer-view/{id}', [CustomersController::class, 'view'])->name('customers.view')->middleware('auth');
        Route::post('customers/save', [CustomersController::class, 'save'])->name('customers.save')->middleware('auth');
        Route::get('/customers-product_list/{id}', [CustomersController::class, 'product_list'])->name('customers.product_list')->middleware('auth');
        Route::post('customers/product_details_list', [CustomersController::class, 'product_details_list'])->name('customers.product_details_list')->middleware('auth');
        Route::post('customers/product-list-search', [CustomersController::class, 'product_list_search'])->name('customers.product_list_search')->middleware('auth');
        Route::post('customers/is_status', [CustomersController::class, 'is_status'])->name('customers.is_status')->middleware('auth');
        Route::post('customers/export', [CustomersController::class, 'export'])->name('customer.export')->middleware('auth');
        Route::post('view-cart-comment', [CustomersController::class, 'view_cart_comment'])->name('view.cart.comment')->middleware('auth');
        Route::post('change-approval-status', [CustomersController::class, 'update_approval_status'])->name('customer.approval.status')->middleware('auth');
        Route::post('check-user-access', [CustomersController::class, 'check_user_access'])->name('customer.check.access')->middleware('auth');
        Route::post('update-user-access', [CustomersController::class, 'update_user_access'])->name('customer.update.access')->middleware('auth');

        //Orders
        Route::get('/order', [OrdersController::class, 'orders_dash_index'])->name('orders.dash_index')->middleware('auth');
        Route::get('/orders', [OrdersController::class, 'orders_index'])->name('orders.index')->middleware('auth');
        Route::post('orders/list', [OrdersController::class, 'list'])->name('orders.list')->middleware('auth');
        Route::post('orders/search', [OrdersController::class, 'search_orders'])->name('orders.search')->middleware('auth');
        Route::post('orders/export', [OrdersController::class, 'export'])->name('orders.export')->middleware('auth');
        Route::get('/orders/{id}', [OrdersController::class, 'details'])->name('orders.details')->middleware('auth');
        Route::post('get-orders-status', [OrdersController::class, 'get_status'])->name('orders.get.status')->middleware('auth');
        Route::post('change-orders-status', [OrdersController::class, 'change_status'])->name('orders.change.status')->middleware('auth');

        // Access Control
        Route::get('/access-control-index', [AccessControlController::class, 'dashboard'])->name('accesscontrole.dash_index')->middleware('auth');
        Route::get('/access-control', [AccessControlController::class, 'index'])->name('accesscontrole.index')->middleware('auth');
        Route::post('/access-control-save', [AccessControlController::class, 'save'])->name('accesscontrole.save')->middleware('auth');

        // Notification
        Route::get('/announcement', [NotificationController::class, 'index'])->name('notification.index')->middleware('auth');
        Route::post('notification/save', [NotificationController::class, 'save'])->name('notification.save')->middleware('auth');

    });
});
