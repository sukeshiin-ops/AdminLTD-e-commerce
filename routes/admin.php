<?php

use App\Http\Controllers\AttribueController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EditValueController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMangeController;
use App\Http\Middleware\checkLogin;
use App\Http\Middleware\NotAccessLoginIfAuthorize;
use Illuminate\Support\Facades\Route;




Route::middleware([NotAccessLoginIfAuthorize::class])->group(function () {
    Route::view('register-page', 'admin.auth.register')->name('registerPage');

    Route::view('login-page', 'admin.auth.login')->name('LoginPage');

    Route::view('forgot-password', 'admin.auth.forgot-password')->name('ForgotPasswordPage');

    Route::view('reset-password', 'admin.auth.reset-password')->name('ResetPasswordPage');
});


Route::post('register', [UserController::class, 'register'])->name('register.now');

Route::post('login', [UserController::class, 'login'])->name('login.now');

Route::post('change_pass', [UserController::class, 'change_pass'])->name('change.password');

Route::post('sendOtp', [UserController::class, 'sendOtp'])->name('send.opt');

Route::post('verifyOtp', [UserController::class, 'verifyOtp'])->name('verify.opt.now');

Route::post('reset_pass', [UserController::class, 'reset_pass'])->name('reset.password.now');

Route::post('send_password', [UserController::class, 'Send_Password_to_User'])->name('send.password.now');

Route::resource('users', UserMangeController::class);

Route::get('all-Product', [ProductController::class, 'allProduct'])->name('view.all.product');


//admin-product-curd
Route::get('/seller/product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/seller/product/store', [ProductController::class, 'store'])->name('seller.product.store');




Route::middleware([checkLogin::class])->group(function () {

    Route::get('admin-page', function () {
        return view('admin.layout.index');
    })->name('dashboard.page');


    Route::get('logout', [UserController::class, 'logout'])->name('logout.now');

    Route::view('change-password', 'admin.auth.change-password')->name('change.password.now');

    Route::view('all-user', 'admin.User.allUser')->name('view-All-User.now');


    //Route::view('update-user', 'admin.User.User-update')->name('update.user.page');

    Route::view('add-user', 'admin.User.Add-user')->name('add.user.now');

    Route::view('categories', 'admin.Category.all-category')->name('view.category.now');


    Route::get('all-categorie', [CategoryController::class, 'index'])->name('all.category.now');
    Route::get('add-categorie', [CategoryController::class, 'show'])->name('show.category.now');
    Route::post('add-categorie-db', [CategoryController::class, 'create'])->name('add.category.now');


    Route::view('add-categories', 'admin.Category.add-category')->name('add.categories.now');

    //Attribute
    Route::get('all-attibute', [AttributeController::class, 'showAttribue'])->name('show.all.attribute');

    Route::get('delete-attribute/{id}', [AttributeController::class, 'deleteAttribute'])->name('delete.attribute.now');

    Route::view('add-attribute', 'admin.attribute.add-attribute')->name('add.attribute.now');

    Route::post('store-attribute', [AttributeController::class, 'store'])->name('store.attribute.now');

    Route::get('edit-attribute/{id}', [AttributeController::class, 'updatePage'])->name('update.page.attribute.now');

    Route::post('update-attribute{id}',  [AttributeController::class, 'updateAttribute'])->name('update.attribute.now');


    //Attribute-value
    Route::view('all-attribute-value', 'admin.attribute.all-attribute-value')->name('view.all-attribute.value');


    //Edit Value Controller
    Route::resource('edit-value', EditValueController::class);

    //for add value
    Route::get('add-value/{id}', [AttributeController::class, 'createValue'])->name('add-value-now');
    Route::post('store-value/{id}', [AttributeController::class, 'storeValue'])->name('store-value-now');


    //for attribute route in add prouduct in admin
    Route::post('/get-attribute-values', [ProductController::class, 'getAttributeValues'])
        ->name('get.attribute.values');
})->can('isAdmin');










//E-commerce




Route::view('/', 'e-commerce.home')->name('e-commerce-page');


Route::get('view_image/{id}', [ProductController::class, 'viewProductImage'])->name('view.image.now');
Route::view('e-commerce/view', 'e-commerce.view-product')->name('e-commerce-page.view');
Route::get('category-select', [CategoryController::class, 'showCategory'])->name('select');

Route::get('category/{id}', [CategoryController::class, 'showCategoryProducts'])->name('category.products');

Route::get('e-commerce', [CategoryController::class, 'showCategory'])->name('e-commerce-page');

Route::get('category/{id}', [CategoryController::class, 'showCategoryProducts'])->name('category.products');

Route::get('seller-product', [SellerController::class, 'purchasedUsers'])->name('view.seller.product');

Route::get('check-role/{id}', [UserController::class, 'checkwhoAccessCart'])->name('cart.access');

Route::view('user-profile-image', 'e-commerce/user-profile')->name('view.user.profile');

Route::view('cart-page', 'e-commerce.seller.cart-page')->name('view.cart.page');

Route::get('inc-order/{id}', [CartController::class, 'increment'])->name('product-increment');

Route::get('dec-order/{id}', [CartController::class, 'decrement'])->name('product-decrement');


Route::get('rem-order/{id}', [CartController::class, 'remove'])->name('product-remove');


Route::view('seller-order-page', 'e-commerce.seller.my-order')->name('my.order.page');



Route::get('pp', [SellerController::class, 'purchasedUsers'])
    ->name('seller.purchased.users');


Route::get('aa/{id}', [SellerController::class, 'orderPage'])->name('order.page');

Route::get('invoice-page/{id}', [SellerController::class, 'invoicePage'])->name('invoice.page');






//stock
Route::get('seller/stock/{id}/edit', [StockController::class, 'edit'])->name('seller.stock.edit');
Route::put('seller/stock/{id}', [StockController::class, 'update'])->name('seller.stock.update');
Route::get('/seller/stock/create', [StockController::class, 'create'])->name('seller.stock.create');
Route::post('/seller/stock/store', [StockController::class, 'store'])->name('seller.stock.store');


//after cart
Route::get('order-checkout', [OrderController::class, 'OrderCheckout'])->name('order.checkout');
Route::get('user-order-page', [OrderController::class, 'userOrders'])->name('user.order.page');


//delete product
Route::get('delete-seller-product/{id}', [StockController::class, 'deleteProduct'])->name('delete.seller.product');
Route::get('edit-page-seller-produt/{id}', [StockController::class, 'editPage'])->name('edit.page.seller.product');

//update Product
Route::patch('update-seller-product/{id}', [StockController::class, 'updateProduct'])->name('update.seller.product');
