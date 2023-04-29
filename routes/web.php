<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerregiController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\CuponController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\githubController;
use App\Http\Controllers\googleController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SslCommerzPaymentController;

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

Route::get('/',[App\Http\Controllers\FrontendController::class,'index'])->name('index');
Route::get('product/details/{slug}',[App\Http\Controllers\FrontendController::class,'details'])->name('details');
Route::post('/getsize',[App\Http\Controllers\FrontendController::class,'getsize']);
Route::get('/customer/register/login',[App\Http\Controllers\FrontendController::class,'customer_register_login'])->name('customer.reglogin');
Route::get('/cart',[App\Http\Controllers\FrontendController::class,'cart_view'])->name('cart.view');
Route::get('/category/product/{category_id}',[App\Http\Controllers\FrontendController::class,'category_product'])->name('category.product');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/user', [App\Http\Controllers\HomeController::class, 'user'])->name('user');
Route::get('/user/delete/{user_id}',[App\Http\Controllers\HomeController::class,'destroy'])->name('user.delete');

Route::get('/profile',[App\Http\Controllers\HomeController::class,'profile'])->name('profile');
Route::post('/profile/update',[App\Http\Controllers\HomeController::class,'profile_update'])->name('profile.update');
Route::post('/profile/password/update',[App\Http\Controllers\HomeController::class,'update_password'])->name('update.password');
Route::post('/profile/photo/update',[App\Http\Controllers\HomeController::class,'update_photo'])->name('update.photo');

Route::get('/category', [App\Http\Controllers\CategoryController::class, 'category_index'])->name('category.index');
Route::post('/category/store', [App\Http\Controllers\CategoryController::class, 'store'])->name('store');
Route::get('/category/edit/{category_id}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category/update/{category_id}', [App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
Route::get('/category/delete/{category_id}', [App\Http\Controllers\CategoryController::class, 'category_destroy'])->name('category.delete');

Route::get('/category/delete/hard/{category_id}', [App\Http\Controllers\CategoryController::class, 'category_hard_destroy'])->name('category.hard.restore');

Route::get('/category/restore/{category_id}', [App\Http\Controllers\CategoryController::class, 'restore'])->name('category.restore');

//seub category
Route::get('/subcategory',[App\Http\Controllers\SubcategoryController::class,'subcategory'])->name('subcategory');
Route::post('/subcategory/store',[App\Http\Controllers\SubcategoryController::class,'subcategory_store'])->name('subcategory.store');
Route::get('/subcategory/edit/{subcategory_id}',[App\Http\Controllers\SubcategoryController::class,'subcategory_edit'])->name('subcategory.edit');
Route::post('/subcategory/update',[App\Http\Controllers\SubcategoryController::class,'subcategory_update'])->name('subcategory.update');
Route::get('/subcategory/delete/{delete_id}',[App\Http\Controllers\SubcategoryController::class,'subcategory_delete'])->name('subcategory.delete');

// product
Route::get('/product',[App\Http\Controllers\ProductController::class,'product'])->name('product');
Route::post('/getsubcategory',[App\Http\Controllers\ProductController::class,'getsubcategory']);
Route::post('/product/store',[App\Http\Controllers\ProductController::class,'product_store'])->name('product.store');
Route::get('/product/list',[App\Http\Controllers\ProductController::class,'product_list'])->name('product.list');
Route::get('/product/variation',[App\Http\Controllers\ProductController::class,'product_variation'])->name('product.variation');
Route::post('/product/variation/store',[App\Http\Controllers\ProductController::class,'variation_store'])->name('variation.store');
Route::get('/product/inventory/{inventory_id}',[App\Http\Controllers\ProductController::class,'product_inventory'])->name('product.inventory');
Route::post('/product/inventory/store',[App\Http\Controllers\ProductController::class,'inventory_store'])->name('inventory.store');
Route::get('/product/product/delete/{product_id}',[App\Http\Controllers\ProductController::class,'product_delete'])->name('product.delete');

// cart 
Route::post('add/cart',[App\Http\Controllers\CartController::class,'add_cart'])->name('add.cart');
Route::get('cart/remove/{cart_id}',[App\Http\Controllers\CartController::class,'cart_remove'])->name('cart.remove');
Route::post('cart/update',[App\Http\Controllers\CartController::class,'cart_update'])->name('cart.update');

//customer.log.regi
Route::post('/customer/register',[CustomerregiController::class,'customer_regi'])->name('customer.regi');

Route::post('/customer/login',[CustomerLoginController::class,'customer_login'])->name('customer.login');
Route::get('/customer/logout',[CustomerLoginController::class,'customer_logout'])->name('customer.logout');
Route::get('/customer/profile',[CustomerController::class,'customer_profile'])->name('customer.profile');
Route::post('/customer/profile/update',[CustomerController::class,'customer_profile_update'])->name('customer.profile_update');
Route::get('/my/order',[CustomerController::class,'my_order'])->name('my.order');
//email_verify
Route::get('customer/email/verify/{token}',[CustomerController::class,'customer_email_verify']);



//cupon

Route::get('/coupon',[CuponController::class,'coupon'])->name('coupon');
Route::post('/coupon/add',[CuponController::class,'add_coupon'])->name('add.coupon');
Route::get('/coupon/delete/{coupon_id}',[CuponController::class,'coupon_delete'])->name('coupon.delete');

//checkout
Route::get('/checkout',[CheckoutController::class,'checkout'])->name('checkout');
Route::post('/getCity',[CheckoutController::class,'getCity']);
Route::post('/checkout/store',[CheckoutController::class,'checkout_store'])->name('checkout.store');
Route::get('/order/success/{abc}',[CheckoutController::class,'order_success'])->name('order.success');

//Order
Route::get('/orders',[OrderController::class,'orders'])->name('orders');
Route::post('/order/status',[OrderController::class,'orders_status'])->name('order.status');


//stripe payment
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});

// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::get('/pay', [SslCommerzPaymentController::class, 'index'])->name('pay');
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

//invoice

Route::get('/order/download/invoice/{order_id}',[CustomerController::class,'download_invoice'])->name('download.invoice');

//role management
Route::get('/role',[RoleController::class,'role'])->name('role');
Route::post('/role/permission/store',[RoleController::class,'pemission_store'])->name('permission.store');
Route::post('/role/store',[RoleController::class,'role_store'])->name('role.store');
Route::post('/role/assign/role',[RoleController::class,'assign_role'])->name('assign.role');
Route::get('/role/remove/{user_id}',[RoleController::class,'remove_role'])->name('remove.role');
Route::get('/role/delete/permission/{role_id}',[RoleController::class,'delete_permission'])->name('delete.permission');

//search

Route::get('/search',[SearchController::class,'search'])->name('search'); 

// password Reset
Route::get('/password/reset/req/form',[CustomerController::class,'password_reset_req_form'])->name('password.reset.req.form'); 
Route::Post('/password/reset/req/send',[CustomerController::class,'password_reset_req_send'])->name('password.reset.req.send');
Route::get('/customer/password/reset/req/form/{token}',[CustomerController::class,'customer_password_reset_form'])->name('customer.password_reset_form');
Route::post('/password/reset/confirm',[CustomerController::class,'password_reset_confirm'])->name('password.reset.confirm');

//social login
Route::get('/github/redirect',[githubController::class,'github_redirect'])->name('github.redirect');
Route::get('/github/callback',[githubController::class,'github_callback'])->name('github.callback');

Route::get('/google/redirect',[googleController::class,'google_redirect'])->name('google.redirect');
Route::get('/google/callback',[googleController::class,'google_callback'])->name('google.callback');

//review
Route::post('/review/store',[FrontendController::class,'review_store'])->name('review.store');



