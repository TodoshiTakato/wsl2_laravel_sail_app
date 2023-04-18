<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\CategoriesController0001;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MyController0001;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductsController0001;
use App\Http\Controllers\TaskController;

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

//                            MAIN PAGE
// Route::get('/', function () { return view('welcome'); });           // Old version
Route::get('/', [CategoriesController0001::class, 'index_page'])->name('main_page');
Route::get('/test', [UserController::class, 'test'])->name('test');


Route::controller(UserController::class)->group(function () {
    Route::get ('/register',                         'getRegister')          ->name('getRegister');            // User Get Register Page.
    Route::post('/register',                         'postRegister')         ->name('postRegister');           // User Post Register. Create a user.
    Route::post('/ajax-register',                    'ajaxRegister')         ->name('ajaxRegister');           // User Ajax Register. Create a user.

    Route::get ('/login',                            'getLogin')             ->name('getLogin');               // User Get Login Page.
    Route::post('/login',                            'postLogin')            ->name('postLogin');              // User Post Login. Authenticate the user.
    Route::post('/ajax-login',                       'ajaxLogin')            ->name('ajaxLogin');              // User Ajax Login. Authenticate the user.

    Route::get ('/forget-password',                  'getForgetPassword')    ->name('getForgetPassword');      // User Get ForgetPassword Page.
//    Route::post('/forget-password',                  'postForgetPassword')   ->name('postForgetPassword');     // User Post ForgetPassword.

    Route::get ('/reset-password/{reset_code}',      'getResetPassword')     ->name('getResetPassword');       // User Get ResetPassword Page.
    Route::post('/reset-password/{reset_code}',      'postResetPassword')    ->name('postResetPassword');      // User Post ResetPassword.

    Route::get ('/home',                             'home')                 ->name('home');                   // Verify the user data.
    Route::post('/logout',                           'logout')               ->name('logout');                 // Verify the user data.

    Route::post('/check_username_unique',            'check_username_unique')->name('check_username_unique');  // check_username_unique
    Route::post('/check_email_unique',               'check_email_unique')   ->name('check_email_unique');     // check_email_unique
    Route::get ('/verify-email/{verification_code}', 'verify_email')         ->name('verify_email');           // verify_email
});

//                            Hello World Pages
Route::controller(MyController0001::class)->group( function () {
    // Hello World. Returning HTML as a string. No variable passing.
    Route::get('/hello0000', 'hello0000')->name('hello0000');

    // Hello World. Returning HTML as a Blade:
    Route::get('/hello0001', 'hello0001')->name('hello0001');  // No variable passing.
    Route::get('/hello0002', 'hello0002')->name('hello0002');  // Passing variable way #1
    Route::get('/hello0003', 'hello0003')->name('hello0003');  // Passing variable way #2
    Route::get('/hello0004', 'hello0004')->name('hello0004');  // Passing variable way #3
});


//                            Hello User Pages
Route::controller(MyController0001::class)->group( function () {
    // Hello World. Returning HTML as a string. No variable passing.
    Route::get('/hello0000',              'hello0000')->name('hello0000');

    // Hello World. Returning HTML as a Blade:
    Route::get('/hello0001',              'hello0001')          ->name('hello0001');      // No variable passing.
    Route::get('/hello0002',              'hello0002')          ->name('hello0002');      // Passing variable way #1
    Route::get('/hello0003',              'hello0003')          ->name('hello0003');      // Passing variable way #2
    Route::get('/hello0004',              'hello0004')          ->name('hello0004');      // Passing variable way #3

    Route::get('/hello0005',              'index')              ->name('hello0005');      // User. Using Controller. Returning HTML as a string.
    Route::get('/hello0006/{variable?}',  'outputting_variable')->name('hello0006_var');  // Routing with optional variable.
    // Passing variable way #1
    Route::get('/hello_user',             'index')              ->name('hello_user');     //~dfgdsfgdfgdfgdg
    Route::get('/hello_user/{variable?}', 'outputting_variable')->name('hello_user_var'); //~dfgdsfgdfgdfgdg

    //                            HTTP Parser Pages
    Route::get('/http',     'parsed_http')->name('get_parsed_http');  // Using HTTP request.
    Route::get('/http_raw', 'raw_http')   ->name('get_raw_http');     // Using HTTP request.
    Route::get('/layout',   'layout')     ->name('layout');           // Verify the user data.
});


//Route::post('/shop/products/', 'MyController0001@index');
Route::group([              // Route Group Shop.
    'prefix' => 'shop' ,
    'as'     => 'shop.',
], static function () {
    Route::controller(ShopController::class)->group( function () {
        Route::get('',         'index')  ->name('index');    // Shop Home Index Page.
        Route::get('/contact', 'contact')->name('contact');  // Shop Contact Page.
        Route::get('/about',   'about')  ->name('about');    // Shop About Page.

        Route::group([              // Route Group Shop Products.
            'prefix' => 'products',
            'as'     => 'products',
        ], static function () {
            Route::get   ('/',          'products');                                                    // Shop Products Page.
            Route::post  ('/{product}', 'addToCart')          ->name('.add_to_cart');             // Shop Product add_to_cart Action.
            Route::put   ('/{product}', 'subtractOneFromCart')->name('.subtract_one_from_cart');  // Shop Product subtract_one_from_cart Action.
            Route::delete('/{product}', 'removeFromCart')     ->name('.remove_from_cart');        // Shop Product remove_from_cart Action.
        });

        Route::group([              // Route Group Shop Cart.
            'prefix' => 'cart',
            'as'     => 'cart',
        ], function () {
            Route::get('/cart',             'getCart')           ->name('.update_quantity');  // Shop Cart Page.
            Route::get('/',                 'cart')              ->name('.load_cart_data');   // Shop Cart Page.
            Route::put('/update/{product}', 'cartUpdateQuantity')->name('.update_quantity');  // shop.cart.update_quantity Action.
            Route::get('/load',             'cartLoadData')      ->name('.load_cart_data');   // shop.cart.load_cart_data Action.
            Route::get('/clear',            'cartClear')         ->name('.clear_cart');       // shop.cart.clear_cart Action.
        });
    });
});


Route::middleware(['auth'])->group( function () {
    Route::group([
        'prefix'     => 'admin'   ,
        'middleware' => 'is_admin',
        'as'         => 'admin.'  ,
    ], static function () {
        Route::controller(AdminController::class)->group( function () {
            Route::get('admin', 'index')->name('index');
        });
    });

    Route::group([
        'prefix' => 'user' ,
        'as'     => 'user.',
    ], static function () {
        //                            Categories & Products PAGE
        Route::controller(CategoriesController0001::class)->group( function () {
            Route::get('/categories',      'Categories') ->name('get_categories');
            Route::get('/categories/{id}', 'Category')   ->name('get_category');
        });
        Route::controller(ProductsController0001::class)->group( function () {
            Route::get('/products',        'Products')   ->name('get_products');
            Route::get('/products/{id}',   'Product')    ->name('get_product');
        });


        //                            Orders & OrderItems PAGE
        Route::resource('orders',      OrderController::class);
        Route::resource('order-items', OrderItemController::class);

        //                            Tasks PAGE
        Route::name('tasks.')->controller(TaskController::class)->group( function () {
            Route::get   ('/tasks',               'index')      ->name('tasks_main_page');
            Route::get   ('/task/{task_id}/info', 'task_info')  ->name('task_info_page');
            Route::post  ('/task',                'post')       ->name('post_a_task');
            Route::post  ('/task/{task_id}',      'rate_a_task')->name('rate_a_task');
            Route::get   ('/task/{task?}',        'task_form')  ->name('task_form_page');
            Route::put   ('/task/{task}',         'update')     ->name('update_a_task');
            Route::delete('/task/delete/{task}',  'delete')     ->name('delete_a_task');
        });
    });
});

