<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\CustomerAuthController as CustomerAuth;
use App\Http\Controllers\Web\MyorderController;
use App\Http\Controllers\Web\ContactusController;
use App\Http\Controllers\Web\ContentpageController;
use App\Http\Controllers\Web\RatingReviewController;
use App\Http\Controllers\Web\ShoppingCartController;
use App\Http\Controllers\Web\NotificationController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\WishlistController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\CollectionController;
use App\Http\Controllers\Web\OrderController;



use App\Http\Controllers\Admin\AuthController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('web.index');
// });




Route::get('/', [HomeController::class, 'index'])->name('customer.index');


Route::prefix('customer')->name('customer.')->group(function () {
  
  Route::get('/', [HomeController::class, 'index'])->name('customer.index');
  Route::get('home', [HomeController::class, 'home'])->name('customer.home');

  Route::get('signupuser', [CustomerAuth::class, 'signupuser'])->name('signupuser');
  Route::post('signup', [CustomerAuth::class, 'signupPost'])->name('customer.signup');
  Route::get('loginuser', [CustomerAuth::class, 'loginuser'])->name('loginuser'); 
  Route::match(['get', 'post'], 'login', [CustomerAuth::class, 'loginPost'])->name('customer.login');
  Route::get('verify', [CustomerAuth::class, 'verify'])->name('verify');
  Route::post('verify_post', [CustomerAuth::class, 'verify_post'])->name('verify_post');
  Route::get('forgot_verify', [CustomerAuth::class, 'forgot_verify'])->name('forgot_verify');
  Route::post('forgot_post', [CustomerAuth::class, 'forgot_post'])->name('forgot_post');
  Route::get('forgot_resend', [CustomerAuth::class, 'forgot_resend'])->name('forgot_resend');
  Route::post('forgot_resend_otp', [CustomerAuth::class, 'forgot_resend_otp'])->name('forgot_resend_otp');
  Route::get('resend', [CustomerAuth::class, 'resend'])->name('resend');
  Route::post('resend_otp', [CustomerAuth::class, 'resend_otp'])->name('resend_otp');
  Route::get('forgot', [CustomerAuth::class, 'forgot'])->name('forgot');
  Route::post('forgotpassword', [CustomerAuth::class, 'forgotpassword'])->name('forgotpassword');
  Route::get('emailverify', [CustomerAuth::class, 'emailverify'])->name('emailverify');
  Route::get('/account', [CustomerAuth::class, 'myAccount'])->name('customer.myAccount');
  Route::get('change-password', [CustomerAuth::class, 'changePassword'])->name('changePassword');
  Route::post('change_password', [CustomerAuth::class, 'changePasswordPost'])->name('changePasswordPost');
  Route::get('reset_password', [CustomerAuth::class, 'reset_password'])->name('reset_password');
  Route::post('reset-password-post', [CustomerAuth::class, 'reset_password_post'])->name('reset_password_post');
  Route::post('verify_reset_post', [CustomerAuth::class, 'verify_reset_post'])->name('verify_reset_post');
  Route::get('reset_emailverify', [CustomerAuth::class, 'reset_emailverify'])->name('reset_emailverify');


        Route::get('my-order', [MyorderController::class, 'myOrder'])->name('myOrder');
        Route::get('dounload_invoice/{order_id}', [MyorderController::class, 'dounload_invoice'])->name('dounload_invoice');
        Route::get('report', [MyorderController::class, 'report'])->name('report');
        Route::get('review', [MyorderController::class, 'review'])->name('review');
        Route::get('cancle_order', [MyorderController::class, 'cancle_order'])->name('cancle_order');
        Route::get('contactus', [ContactusController::class, 'contactus'])->name('contactus');
        Route::post('contactus_post', [ContactusController::class, 'contactus_post'])->name('contactus_post');
        Route::get('aboutus', [ContentpageController::class, 'aboutus'])->name('aboutus');
        Route::get('privacy-policy', [ContentpageController::class, 'privacyPolicy'])->name('privacyPolicy');
        Route::get('term-condition', [ContentpageController::class, 'termcondition'])->name('termcondition');
        Route::get('faq', [ContentpageController::class, 'faq'])->name('faq');
        Route::get('rating-review', [RatingReviewController::class, 'ratingreview'])->name('ratingreview');
        Route::get('shopping-cart', [ShoppingCartController::class, 'shoppingcart'])->name('shoppingcart');
        // Route::post('addtocart/{product_id}', [ShoppingCartController::class, 'addtocart'])->name('addtocart');
        Route::match(['get', 'post'], 'addtocart/{product_id}', [ShoppingCartController::class, 'addtocart'])->name('addtocart');
        Route::get('getcartcount', [ShoppingCartController::class, 'getcartcount'])->name('getcartcount');
        Route::get('remove_from_cart/{cart_id}', [ShoppingCartController::class, 'remove_from_cart'])->name('remove_from_cart');
        Route::post('change_quantity', [ShoppingCartController::class, 'change_quantity'])->name('change_quantity');
        Route::get('getsubtotal', [ShoppingCartController::class, 'getsubtotal'])->name('getsubtotal');
        Route::get('collection/{collection_id}', [CollectionController::class, 'collection'])->name('collection');
        Route::get('payment', [OrderController::class, 'payment'])->name('payment');
        Route::get('notification', [NotificationController::class, 'notification'])->name('notification');
        Route::get('category', [CategoryController::class, 'category'])->name('category');
        Route::get('category_product/{category_id}', [CategoryController::class, 'category_product'])->name('category_product'); 
        Route::get('guestuser', [CustomerAuth::class, 'guestuser'])->name('guestuser'); 
        Route::get('addwishlist/{product_id}/{user_id}', [WishlistController::class, 'addwishlist'])->name('addwishlist'); 
        Route::get('wishlist', [WishlistController::class, 'wishlist'])->name('wishlist'); 
        Route::get('remove_wishlist/{wishlist_id}', [WishlistController::class, 'remove_wishlist'])->name('remove_wishlist'); 
        Route::post('order', [OrderController::class, 'order'])->name('order');
        Route::post('add_card', [OrderController::class, 'add_card'])->name('add_card');
        Route::get('order_list', [OrderController::class, 'order_list'])->name('order_list');
        Route::get('thanks', [OrderController::class, 'thanks'])->name('thanks');
        Route::get('featured_product', [ProductController::class, 'featurd_product'])->name('featurd_product');
        Route::get('filter', [CategoryController::class, 'filter'])->name('filter');
        Route::get('sub_category', [CategoryController::class, 'sub_category'])->name('sub_category');
        Route::get('product_details/{product_id}', [ProductController::class, 'product_details'])->name('product_details');
        Route::post('editprofile', [CustomerAuth::class, 'editprofile'])->name('editprofile');
        Route::post('change_address', [CustomerAuth::class, 'change_address'])->name('change_address');
        Route::post('add_rating', [ProductController::class, 'add_rating'])->name('add_rating');
        Route::get('edit_address', [CustomerAuth::class, 'edit_address'])->name('edit_address');
        Route::get('logout', [CustomerAuth::class, 'logout'])->name('logout'); 
});








// --------------------------------------------------------------------ADMIN-------------------------------------------------------------------------------------------






Route::get('/admin', [AuthController::class, 'login'])->name('login');
Route::post('login_post', [AuthController::class, 'login_post'])->name('login_post');


// ---------Forgot password

Route::get('forgot_password_form', [AuthController::class, 'forgot_password_form'])->name('forgot_password_form');
Route::post('forgot_password_email', [AuthController::class, 'forgot_password_email'])->name('forgot_password_email');
Route::get('reset/{token}', [AuthController::class, 'reset'])->name('reset');
Route::post('reset_password', [AuthController::class, 'reset_password'])->name('reset_password');
Route::group(['middleware' => ['auth:admin']], function () {
Route::get('home', [App\Http\Controllers\Admin\HomeController::class, 'home'])->name('admin.home');
Route::get('view_profile/{id}', [AuthController::class, 'view_profile'])->name('view_profile');
Route::post('update_profile', [AuthController::class, 'update_profile'])->name('update_profile'); 



// --------User

Route::get('user_listing', [App\Http\Controllers\Admin\UserController::class, 'user_listing'])->name('user_listing');
Route::get('get_user_listing', [App\Http\Controllers\Admin\UserController::class, 'userListing'])->name('get_user_listing');
Route::post('block_user', [App\Http\Controllers\Admin\UserController::class, 'block_user'])->name('block_user');
Route::post('unblock_user', [App\Http\Controllers\Admin\UserController::class, 'unblock_user'])->name('unblock_user');
Route::get('view_user/{id}', [App\Http\Controllers\Admin\UserController::class, 'ViewUser'])->name('view_user');



//---------------Category

Route::get('category_listing', [App\Http\Controllers\Admin\CategoryController::class, 'category_listing'])->name('category_listing');
Route::get('get_cat_listing', [App\Http\Controllers\Admin\CategoryController::class, 'get_cat_listing'])->name('get_cat_listing');
Route::get('view_category/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'view_category'])->name('view_category');
Route::post('active_cat', [App\Http\Controllers\Admin\CategoryController::class, 'active_cat'])->name('active_cat');
Route::post('inactive_cat', [App\Http\Controllers\Admin\CategoryController::class, 'inactive_cat'])->name('inactive_cat');
Route::post('delete_cat', [App\Http\Controllers\Admin\CategoryController::class, 'delete_cat'])->name('delete_cat');
Route::get('add_category', [App\Http\Controllers\Admin\CategoryController::class, 'add_cat'])->name('add_cat');
Route::post('add_cat_post', [App\Http\Controllers\Admin\CategoryController::class, 'add_cat_post'])->name('add_cat_post');
Route::get('edit_category/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'edit_cat'])->name('edit_cat');
Route::put('update_category/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update_category'])->name('update_category');
Route::post('delete_category', [App\Http\Controllers\Admin\CategoryController::class, 'delete_category'])->name('delete_category');


//---------------Subcategory

Route::get('subcategory_listing', [App\Http\Controllers\Admin\SubCategoryController::class, 'subcategory_listing'])->name('subcategory_listing');
Route::get('get_subcategory_listing', [App\Http\Controllers\Admin\SubCategoryController::class, 'get_subcategory_listing'])->name('get_subcategory_listing');
Route::get('view_subcategory/{id}', [App\Http\Controllers\Admin\SubCategoryController::class, 'view_subcategory'])->name('view_subcategory');
Route::post('active_subcat', [App\Http\Controllers\Admin\SubCategoryController::class, 'active_subcat'])->name('active_subcat');
Route::post('inactive_subcat', [App\Http\Controllers\Admin\SubCategoryController::class, 'inactive_subcat'])->name('inactive_subcat');
Route::post('delete_subcat', [App\Http\Controllers\Admin\SubCategoryController::class, 'delete_subcat'])->name('delete_subcat');
Route::get('add_subcategory', [App\Http\Controllers\Admin\SubCategoryController::class, 'add_subcategory'])->name('add_subcategory');
Route::post('add_subcat_post', [App\Http\Controllers\Admin\SubCategoryController::class, 'add_subcat_post'])->name('add_subcat_post');
Route::get('edit_subcategory/{id}', [App\Http\Controllers\Admin\SubCategoryController::class, 'edit_subcat'])->name('edit_subcat');
Route::post('update_subcategory/{id}', [App\Http\Controllers\Admin\SubCategoryController::class, 'update_subcategory'])->name('update_subcategory');

//---------------Product

Route::get('product_listing', [App\Http\Controllers\Admin\ProductController::class, 'product_listing'])->name('product_listing');
Route::get('get_product_listing', [App\Http\Controllers\Admin\ProductController::class, 'get_product_listing'])->name('get_product_listing');
Route::get('view_product/{id}', [App\Http\Controllers\Admin\ProductController::class, 'view_product'])->name('view_product');
Route::post('active_product', [App\Http\Controllers\Admin\ProductController::class, 'active_product'])->name('active_product');
Route::post('inactive_product', [App\Http\Controllers\Admin\ProductController::class, 'inactive_product'])->name('inactive_product');
Route::post('delete_product', [App\Http\Controllers\Admin\ProductController::class, 'delete_product'])->name('delete_product');
Route::get('add_product', [App\Http\Controllers\Admin\ProductController::class, 'add_product'])->name('add_product');
Route::post('add_product_post', [App\Http\Controllers\Admin\ProductController::class, 'add_product_post'])->name('add_product_post');
Route::get('edit_product/{id}', [App\Http\Controllers\Admin\ProductController::class, 'edit_product'])->name('edit_product');
Route::put('update_product/{id}', [App\Http\Controllers\Admin\ProductController::class, 'update_product'])->name('update_product');

Route::get('get_sub_category', [App\Http\Controllers\Admin\ProductController::class, 'get_sub_category'])->name('get_sub_category');
Route::post('delete_image', [App\Http\Controllers\Admin\ProductController::class, 'delete_image'])->name('delete_image');



// ------------Banner

Route::get('banner_listing', [App\Http\Controllers\Admin\LandingpageController::class, 'banner_listing'])->name('banner_listing');
Route::get('get_banner_listing', [App\Http\Controllers\Admin\LandingpageController::class, 'get_banner_listing'])->name('get_banner_listing');
Route::get('view_banner/{id}', [App\Http\Controllers\Admin\LandingpageController::class, 'view_banner'])->name('view_banner');
Route::post('active_banner', [App\Http\Controllers\Admin\LandingpageController::class, 'active_banner'])->name('active_banner');
Route::post('inactive_banner', [App\Http\Controllers\Admin\LandingpageController::class, 'inactive_banner'])->name('inactive_banner');
Route::post('delete_banner', [App\Http\Controllers\Admin\LandingpageController::class, 'delete_banner'])->name('delete_banner');
Route::get('add_banner', [App\Http\Controllers\Admin\LandingpageController::class, 'add_banner'])->name('add_banner');
Route::post('add_banner_post', [App\Http\Controllers\Admin\LandingpageController::class, 'add_banner_post'])->name('add_banner_post');
Route::get('edit_banner/{id}', [App\Http\Controllers\Admin\LandingpageController::class, 'edit_banner'])->name('edit_banner');
Route::put('update_banner/{id}', [App\Http\Controllers\Admin\LandingpageController::class, 'update_banner'])->name('update_banner');


// ------------Video

Route::get('video_listing', [App\Http\Controllers\Admin\LandingpageController::class, 'video_listing'])->name('video_listing');
Route::get('get_video_listing', [App\Http\Controllers\Admin\LandingpageController::class, 'get_video_listing'])->name('get_video_listing');
Route::get('view_video/{id}', [App\Http\Controllers\Admin\LandingpageController::class, 'view_video'])->name('view_video');
Route::post('active_video', [App\Http\Controllers\Admin\LandingpageController::class, 'active_video'])->name('active_video');
Route::post('inactive_video', [App\Http\Controllers\Admin\LandingpageController::class, 'inactive_video'])->name('inactive_video');
Route::post('delete_video', [App\Http\Controllers\Admin\LandingpageController::class, 'delete_video'])->name('delete_video');
Route::get('add_video', [App\Http\Controllers\Admin\LandingpageController::class, 'add_video'])->name('add_video');
Route::post('add_video_post', [App\Http\Controllers\Admin\LandingpageController::class, 'add_video_post'])->name('add_video_post');
Route::get('edit_video/{id}', [App\Http\Controllers\Admin\LandingpageController::class, 'edit_video'])->name('edit_video');
Route::put('update_video/{id}', [App\Http\Controllers\Admin\LandingpageController::class, 'update_video'])->name('update_video');


// ------------Collection

Route::get('collection_listing', [App\Http\Controllers\Admin\CollectionController::class, 'collection_listing'])->name('collection_listing');
Route::get('get_collection_listing', [App\Http\Controllers\Admin\CollectionController::class, 'get_collection_listing'])->name('get_collection_listing');
Route::get('view_collection/{id}', [App\Http\Controllers\Admin\CollectionController::class, 'view_collection'])->name('view_collection');
Route::post('active_collection', [App\Http\Controllers\Admin\CollectionController::class, 'active_collection'])->name('active_collection');
Route::post('inactive_collection', [App\Http\Controllers\Admin\CollectionController::class, 'inactive_collection'])->name('inactive_collection');
Route::post('delete_collection', [App\Http\Controllers\Admin\CollectionController::class, 'delete_collection'])->name('delete_collection');
Route::get('add_collection', [App\Http\Controllers\Admin\CollectionController::class, 'add_collection'])->name('add_collection');
Route::post('add_collection_post', [App\Http\Controllers\Admin\CollectionController::class, 'add_collection_post'])->name('add_collection_post');
Route::get('edit_collection/{id}', [App\Http\Controllers\Admin\CollectionController::class, 'edit_collection'])->name('edit_collection');
Route::put('update_collection/{id}', [App\Http\Controllers\Admin\CollectionController::class, 'update_collection'])->name('update_collection');

Route::get('change_password', [AuthController::class, 'change_password'])->name('change_password');
Route::post('update_password', [AuthController::class, 'update_password'])->name('update_password');




Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

});