<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Client\PaymentControllerClient;
use App\Http\Controllers\HomeController;


// kết thúc phần admin
use App\Http\Controllers\Client\ProductController as ProductControllerClient;


// use Stripe\Discount;

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

Route::get('admin', [authController::class, 'login_admin']);
Route::post('admin', [authController::class, 'auth_login_admin']);
Route::get('logout', [authController::class, 'logout']);
Route::group(['middleware' => 'user'], function () {
    Route::get('user/dashboard', [UserController::class, 'dashboard']);
    Route::get('user/orders', [UserController::class, 'orders']);
    Route::get('user/order/detail/{id}', [UserController::class, 'orderDetail']);
    Route::get('user/edit-profile', [UserController::class, 'editProfile']);
    Route::post('user/edit-profile', [UserController::class, 'updateProfile']);
    Route::get('user/change-password', [UserController::class, 'changePassword']);
    Route::post('user/change-password', [UserController::class, 'updateNewPassword']);
    Route::post('add_wishlist', [UserController::class, 'addWishlist']);
    Route::get('wishlist', [UserController::class, 'listMyWishlist']);
    Route::get('evaluate', [UserController::class, 'evaluate']);
});


Route::group(['middleware' => 'admin'], function () {
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard']);
    Route::post('filter_revenue_dashboard', [DashboardController::class, 'filterRevenueDashboard']);
    Route::post('filterRevenueDashboardDefault', [DashboardController::class, 'filterRevenueDashboardDefault']);
    Route::get('filterOptionDate', [DashboardController::class, 'filterOptionDate']);
    Route::get('orderDetailPdf/{order_id}', [DashboardController::class, 'orderDetailPdf']);
  
    
    


    Route::get('admin/admin/list', [AdminController::class, 'list']);
    Route::get('admin/admin/add', [AdminController::class, 'add']);
    Route::post('admin/admin/add', [AdminController::class, 'insert']);
    Route::get('admin/admin/edit/{id}', [AdminController::class, 'edit']);
    Route::post('admin/admin/edit/{id}', [AdminController::class, 'update']);
    Route::get('admin/admin/delete/{id}', [AdminController::class, 'delete']);
    // kết thúc phần crud tài khoản admin


    Route::get('admin/category/list', [CategoryController::class, 'list']);
    Route::get('admin/category/add', [CategoryController::class, 'add']);
    Route::post('admin/category/add', [CategoryController::class, 'insert']);
    Route::get('admin/category/edit/{id}', [CategoryController::class, 'edit']);
    Route::post('admin/category/edit/{id}', [CategoryController::class, 'update']);
    Route::get('admin/category/delete/{id}', [CategoryController::class, 'delete']);

    // kết thúc crud phần danh mục chính

    Route::get('admin/brand/list', [BrandController::class, 'list']);
    Route::get('admin/brand/add', [BrandController::class, 'add']);
    Route::post('admin/brand/add', [BrandController::class, 'insert']);
    Route::get('admin/brand/edit/{id}', [BrandController::class, 'edit']);
    Route::post('admin/brand/edit/{id}', [BrandController::class, 'update']);
    Route::get('admin/brand/delete/{id}', [BrandController::class, 'delete']);

    // kết thúc phần crud thương hiệu

    Route::get('admin/sub_category/list', [SubCategoryController::class, 'list']);
    Route::get('admin/sub_category/add', [SubCategoryController::class, 'add']);
    Route::post('admin/sub_category/add', [SubCategoryController::class, 'insert']);
    Route::get('admin/sub_category/edit/{id}', [SubCategoryController::class, 'edit']);
    Route::post('admin/sub_category/edit/{id}', [SubCategoryController::class, 'update']);
    Route::get('admin/sub_category/delete/{id}', [SubCategoryController::class, 'delete']);

    Route::post('admin/get_sub_category', [SubCategoryController::class, 'get_sub_category']);

    // kết thúc phần crud danh mục phụ
    Route::get('admin/color/list', [ColorController::class, 'list']);
    Route::get('admin/color/add', [ColorController::class, 'add']);
    Route::post('admin/color/add', [ColorController::class, 'insert']);
    Route::get('admin/color/edit/{id}', [ColorController::class, 'edit']);
    Route::post('admin/color/edit/{id}', [ColorController::class, 'update']);
    Route::get('admin/color/delete/{id}', [ColorController::class, 'delete']);

    // kết thúc phần crud màu sắc
    Route::get('admin/discount/list', [DiscountController::class, 'list']);
    Route::get('admin/discount/add', [DiscountController::class, 'add']);
    Route::post('admin/discount/add', [DiscountController::class, 'insert']);
    Route::get('admin/discount/edit/{id}', [DiscountController::class, 'edit']);
    Route::post('admin/discount/edit/{id}', [DiscountController::class, 'update']);
    Route::get('admin/discount/delete/{id}', [DiscountController::class, 'delete']);

    // kết thúc phần crud mã giảm giá

    Route::get('admin/shipping/list', [ShippingController::class, 'list']);
    Route::get('admin/shipping/add', [ShippingController::class, 'add']);
    Route::post('admin/shipping/add', [ShippingController::class, 'insert']);
    Route::get('admin/shipping/edit/{id}', [ShippingController::class, 'edit']);
    Route::post('admin/shipping/edit/{id}', [ShippingController::class, 'update']);
    Route::get('admin/shipping/delete/{id}', [ShippingController::class, 'delete']);


    // kết thúc phần crud mã giảm giá

    Route::get('admin/slider/list', [SliderController::class, 'list']);
    Route::get('admin/slider/add', [SliderController::class, 'add']);
    Route::post('admin/slider/add', [SliderController::class, 'insert']);
    Route::get('admin/slider/edit/{id}', [SliderController::class, 'edit']);
    Route::post('admin/slider/edit/{id}', [SliderController::class, 'update']);
    Route::get('admin/slider/delete/{id}', [SliderController::class, 'delete']);
    // kết thúc phần crud phần phí vận chuyển

    Route::get('admin/product/list', [ProductController::class, 'list']);
    Route::get('admin/product/add', [ProductController::class, 'add']);
    Route::post('admin/product/add', [ProductController::class, 'insert']);
    Route::get('admin/product/edit/{id}', [ProductController::class, 'edit']);
    Route::post('admin/product/edit/{id}', [ProductController::class, 'update']);
    Route::get('admin/product/delete/{id}', [ProductController::class, 'delete']);

    // kết thúc phần sản phẩm 
    Route::get('admin/order/list', [OrderController::class, 'list']);
    Route::get('admin/order/detail/{id}', [OrderController::class, 'detail']);
    Route::get('admin/order_status', [OrderController::class, 'order_status']);
    Route::post('exportOrderExel', [OrderController::class, 'exportOrderExel']);
 





    Route::get('admin/product/delete_image/{id}', [ProductController::class, 'delete_image']);
    // xóa từng ảnh sản phẩm trong phần edit
    Route::post('admin/product_image_sortable', [ProductController::class, 'product_image_sortable']); // sắp xếp lại ảnh bằng ajax
    // kết thúc phần crud sản phẩm
});
// kết thúc phần admin ở đây




Route::get('/', [HomeController::class, 'home']);
Route::get('get-recent-pro-home', [HomeController::class, 'getRecentProHome']);
// Route::get('client/logout', [authController::class, 'logout_admin']);
Route::post('auth_register_client', [authController::class, 'auth_register_client']);
Route::post('auth_login_client', [authController::class, 'auth_login_client']);
Route::get('forgot_password', [authController::class, 'forgot_password']);
Route::post('forgot_password', [authController::class, 'auth_forgot_password']);
Route::get('reset/{token}', [authController::class, 'reset']);
Route::post('reset/{token}', [authController::class, 'reset_password']);

Route::get('activate/{id}', [authController::class, 'activateMail']);
Route::get('cart', [PaymentControllerClient::class, 'cart']);

Route::post('deleteCart', [PaymentControllerClient::class, 'deleteCart']);
Route::post('update-cart', [PaymentControllerClient::class, 'updateCart']);
Route::get('checkout', [PaymentControllerClient::class, 'checkout']);

Route::post('checkout/apply_discount', [PaymentControllerClient::class, 'apply_discount']);
Route::post('checkout/place_order', [PaymentControllerClient::class, 'checkoutPlaceOrder']);
Route::get('checkout/payment', [PaymentControllerClient::class, 'checkoutPayment']);
Route::get('payment_success', [PaymentControllerClient::class, 'payment_success']);



Route::get('search', [ProductControllerClient::class, 'getProductSearch']);
Route::post('get_product_filter_ajax', [ProductControllerClient::class, 'getProductFilterAjax']);
// Route::get('{slug}', [ProductControllerClient::class, 'detail']);
Route::get('{category?}/{subCategory?}', [ProductControllerClient::class, 'getProByCate']);
Route::post('product/add-to-cart', [PaymentControllerClient::class, 'addToCart']);

// demo ví dụ
