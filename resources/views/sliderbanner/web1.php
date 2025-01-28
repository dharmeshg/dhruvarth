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





Route::get('/', function () {

    return redirect()->route('login');

});



// fronted Routes
// Route::get('/frontend', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('track.visitors');

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

    // Metal Rate
    Route::get('/metal-rate', [App\Http\Controllers\Backend\MetalRateController::class, 'index'])->name('metalrate.index')->middleware('auth');
    Route::post('metal-rate/list', [App\Http\Controllers\Backend\MetalRateController::class, 'list'])->name('metalrate.list')->middleware('auth');
    Route::post('metal-rate/save', [App\Http\Controllers\Backend\MetalRateController::class, 'save'])->name('metalrate.save')->middleware('auth');
    Route::post('metal-rate/edit', [App\Http\Controllers\Backend\MetalRateController::class, 'edit'])->name('metalrate.edit')->middleware('auth');
    Route::post('metal-rate/delete', [App\Http\Controllers\Backend\MetalRateController::class, 'delete'])->name('metalrate.delete')->middleware('auth');
    Route::post('metal-rate/pinned', [App\Http\Controllers\Backend\MetalRateController::class, 'pinned_status'])->name('metalrate.pinned')->middleware('auth');
    Route::post('metal-rate/is_status', [App\Http\Controllers\Backend\MetalRateController::class, 'is_status'])->name('metalrate.is_status')->middleware('auth');


    // Daily Status
    Route::get('/daily-status', [App\Http\Controllers\Backend\DailyStatusController::class, 'index'])->name('daliystatus.index')->middleware('auth');
    Route::post('daily-status/save', [App\Http\Controllers\Backend\DailyStatusController::class, 'save'])->name('daliystatus.save')->middleware('auth');
    Route::get('daily-status/add', [App\Http\Controllers\Backend\DailyStatusController::class, 'add'])->name('daliystatus.add')->middleware('auth');
    Route::post('daily-status/list', [App\Http\Controllers\Backend\DailyStatusController::class, 'list'])->name('daliystatus.list')->middleware('auth');
   
    Route::get('/daily-status-edit/{id}', [App\Http\Controllers\Backend\DailyStatusController::class, 'edit'])->name('daliystatus.edit')->middleware('auth');
    Route::get('/daily-status/{id}', [App\Http\Controllers\Backend\DailyStatusController::class, 'delete'])->name('daliystatus.delete')->middleware('auth');
    Route::post('check/featured-daliy-status', [App\Http\Controllers\Backend\DailyStatusController::class, 'check_featured'])->name('daliystatus.check_featured')->middleware('auth');
    





    // Slider Banner
    Route::get('/slider-banner', [App\Http\Controllers\Backend\SliderBannerController::class, 'index'])->name('sliderbanner.index')->middleware('auth');
    Route::get('/add-slider-banner', [App\Http\Controllers\Backend\SliderBannerController::class, 'add'])->name('sliderbanner.add')->middleware('auth');
    Route::post('/list-slider-banner', [App\Http\Controllers\Backend\SliderBannerController::class, 'list'])->name('sliderbanner.list')->middleware('auth');
    Route::post('/save-slider-banner', [App\Http\Controllers\Backend\SliderBannerController::class, 'save'])->name('sliderbanner.save')->middleware('auth');
    Route::get('/edit-slider-banner/{id}', [App\Http\Controllers\Backend\SliderBannerController::class, 'edit'])->name('sliderbanner.edit')->middleware('auth');
    Route::get('slider-banner/delete/{id}', [App\Http\Controllers\Backend\SliderBannerController::class, 'delete'])->name('sliderbanner.delete')->middleware('auth');
    Route::post('/status-slider-banner', [App\Http\Controllers\Backend\SliderBannerController::class, 'status'])->name('adsposter.status')->middleware('auth');
    // Daily Updates routes end

    // New Media routes start

    // Ads Poster

    Route::get('/ads-posters', [App\Http\Controllers\Backend\AdsPosterController::class, 'index'])->name('adsposter.index')->middleware('auth');
    Route::post('/save-ads-posters', [App\Http\Controllers\Backend\AdsPosterController::class, 'save'])->name('adsposter.save')->middleware('auth');
    Route::post('/list-ads-posters', [App\Http\Controllers\Backend\AdsPosterController::class, 'list'])->name('adsposter.list')->middleware('auth');
    Route::post('/edit-ads-posters', [App\Http\Controllers\Backend\AdsPosterController::class, 'edit'])->name('adsposter.edit')->middleware('auth');
    Route::get('/delete-ads-posters/{id}', [App\Http\Controllers\Backend\AdsPosterController::class, 'delete'])->name('adsposter.delete')->middleware('auth');
    Route::post('/status-ads-posters', [App\Http\Controllers\Backend\AdsPosterController::class, 'status'])->name('adsposter.status')->middleware('auth');

    // Logo Slider
    Route::get('/logo-sliders', [App\Http\Controllers\Backend\LogoSliderController::class, 'index'])->name('logoslider.index')->middleware('auth');
    Route::get('/add-logo-sliders', [App\Http\Controllers\Backend\LogoSliderController::class, 'add'])->name('logoslider.add')->middleware('auth');
    Route::post('/save-logo-sliders', [App\Http\Controllers\Backend\LogoSliderController::class, 'save'])->name('logoslider.save')->middleware('auth');
    Route::post('/list-logo-sliders', [App\Http\Controllers\Backend\LogoSliderController::class, 'list'])->name('logoslider.list')->middleware('auth');
    Route::post('/edit-logo-sliders/{id}', [App\Http\Controllers\Backend\LogoSliderController::class, 'edit'])->name('logoslider.edit')->middleware('auth');
    Route::get('/delete-logo-sliders/{id}', [App\Http\Controllers\Backend\LogoSliderController::class, 'delete'])->name('logoslider.delete')->middleware('auth');
    Route::post('/status-logo-sliders', [App\Http\Controllers\Backend\LogoSliderController::class, 'status'])->name('logoslider.status')->middleware('auth');

    // Pdf List

    Route::get('/pdf-list', [App\Http\Controllers\Backend\PdfListController::class, 'index'])->name('pdflist.index')->middleware('auth');
    Route::post('/save-pdf-list', [App\Http\Controllers\Backend\PdfListController::class, 'save'])->name('pdflist.save')->middleware('auth');
    Route::post('/list-pdf-list', [App\Http\Controllers\Backend\PdfListController::class, 'list'])->name('pdflist.list')->middleware('auth');
    Route::post('/edit-pdf-list', [App\Http\Controllers\Backend\PdfListController::class, 'edit'])->name('pdflist.edit')->middleware('auth');
    Route::get('/delete-pdf-list/{id}', [App\Http\Controllers\Backend\PdfListController::class, 'delete'])->name('pdflist.delete')->middleware('auth');
    Route::post('/status-pdf-list', [App\Http\Controllers\Backend\PdfListController::class, 'status'])->name('pdflist.status')->middleware('auth');

    // Page Banner
    Route::get('/page-banner', [App\Http\Controllers\Backend\PageBannerController::class, 'index'])->name('pagebanner.index')->middleware('auth');
    Route::post('/save-page-banner', [App\Http\Controllers\Backend\PageBannerController::class, 'save'])->name('pagebanner.save')->middleware('auth');
    Route::post('/list-page-banner', [App\Http\Controllers\Backend\PageBannerController::class, 'list'])->name('pagebanner.list')->middleware('auth');
    Route::post('/edit-page-banner', [App\Http\Controllers\Backend\PageBannerController::class, 'edit'])->name('pagebanner.edit')->middleware('auth');
    Route::get('/delete-page-banner/{id}', [App\Http\Controllers\Backend\PageBannerController::class, 'delete'])->name('pagebanner.delete')->middleware('auth');
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

    Route::get('/products', [ProductController::class, 'index'])->name('product.index')->middleware('auth');

    // Settings 



    Route::get('/general-setting', [SettingController::class, 'index'])->name('setting.index')->middleware('auth');

    Route::post('setting/update', [SettingController::class, 'save'])->name('setting.add')->middleware('auth');

    Route::get('/email-setting', [SettingController::class, 'email_setting'])->name('setting.email.index')->middleware('auth');

    Route::post('email-setting/update', [SettingController::class, 'email_setting_save'])->name('email.setting.add')->middleware('auth');

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

    Route::post('/media-upload', [MediaController::class, 'upload'])->name('media.upload')->middleware('auth');

    Route::post('/media-detail', [MediaController::class, 'get_image_detail'])->name('media.get.detail')->middleware('auth');

    Route::get('/media-all-upload', [MediaController::class, 'get_all_images'])->name('media.all.upload')->middleware('auth');

    Route::get('/media-all-upload-index', [MediaController::class, 'get_all_images_index'])->name('media.all.upload.index')->middleware('auth');

    Route::post('/media-store-img-details', [MediaController::class, 'store_image_detail'])->name('media.store.detail')->middleware('auth');

    Route::post('/media-delete-img', [MediaController::class, 'delete_image'])->name('media.delete')->middleware('auth');

    Route::get('/media-index', [MediaController::class, 'show_all'])->name('media.showall')->middleware('auth');

    Route::post('/media-image-byid', [MediaController::class, 'get_img_byid'])->name('media.getimg.byid')->middleware('auth');





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




    



     


});


// frontend routes
Route::get('/adminer', function () {
    return redirect('/adminer');
});
Route::get('/{slug}', [FrontendPageController::class, 'index'])->name('frontend.page.index');





