<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Auth\FacebookSocialiteController;

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
Route::get('/clear', function () {
    
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    
    return "Cache is cleared";
});
Route::get('/linkstorage', function () {
    
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('storage:link');
    Artisan::call('migrate', [
        '--force' => true,
    ]);
    // $exitCode = Artisan::call('migrate',
    // array(
    //   '--path' => 'database/migrations',
    //   '--database' => 'dynamicdb',
    //   '--force' => true));
    // $exitCode = Artisan::call('storage:link', [] );
// echo $exitCode; // 0 exit code for no errors.
    return 'DONE'; //Return anything
});
// Route::get('/migrate', function () {
//     $exitCode = Artisan::call('migrate');
//     return 'DONE'; //Return anything
// });
Route::get("/storage-link", function () {
    $targetFolder = storage_path("app/public");
    $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    symlink($targetFolder, $linkFolder);
});

Route::group(['middleware' => ['XSS']], function () {

    Route::get('auth/faebook', 'Auth\FacebookSocialiteController@redirectToFB');
    Route::get('callback/facebook', 'Auth\FacebookSocialiteController@handleCallback');
    Route::get('auth/line', 'Auth\LineSocialiteController@redirectToLINE');
    Route::get('callback/line', 'Auth\LineSocialiteController@handleCallback');
    Route::get('auth/google', 'Auth\GoogleSocialiteController@redirectToGOOGLE');
    Route::get('callback/google', 'Auth\GoogleSocialiteController@handleCallback');



    Route::get('/', 'WelcomeController@index');
    Route::get('/ebook', 'WelcomeController@indexEbook');
    // Route::get('/test', function () {
    //     return view('test');
    // });
    Route::resource('ebook/myEbook', 'MyEbookController')->middleware('is_user');
    Route::resource('ebook/order', 'OrderMasFrontEbookController')->middleware('is_user');

    Route::get('/data','DataController@index');

    Route::get('/ajaxSelectTwoSearch','AjaxSelectTwoController@index');
    Route::post('/ajaxSelectTwoSearch','AjaxSelectTwoController@ajaxSelectTwoSearch');
    Route::get('/ebook/rule/{id}', 'WelcomeController@showPrivacyDetail');
    Route::get('/ebook/rule', 'WelcomeController@showPrivacyAll');

    Route::resource('rate', 'ProductRateController')->middleware('is_user');
    Route::resource('review', 'ProductReviewController');
    Route::get('/products/publisher/{id}', 'WelcomeController@showProductsByPublisher');
    Route::get('/products/bestSeller', 'WelcomeController@showProductsBestSeller');
    Route::get('/products/waitFiction/detail/{id}', 'WelcomeController@showProductsWaitFictionDetail');
    Route::get('/products/waitFiction', 'WelcomeController@showProductsWaitFiction');
    Route::get('/products/serie/{name}', 'WelcomeController@showProductsSerieAll');
    Route::get('/products/serie', 'WelcomeController@showProductsSerieAll');
    Route::get('/products/buffet', 'WelcomeController@showProductsBuffetAll');
    Route::get('/products/blame/detail/{id}', 'WelcomeController@showProductsBlameDetail');
    Route::get('/products/blame', 'WelcomeController@showProductsBlameAll');
    Route::get('/products/detail/{id}', 'WelcomeController@showProductsDetail');
    Route::get('/products', 'WelcomeController@showProductsAll');


    Route::get('ebook/productsEbook/category/{cat}', 'WelcomeController@showProductsEbookCatAll');
    Route::get('ebook/productsEbook/serie/{name}', 'WelcomeController@showProductsEbookSerieAll');
    Route::get('ebook/productsEbook/serie', 'WelcomeController@showProductsEbookSerieAll');
    Route::get('ebook/productsEbook/detail/{id}', 'WelcomeController@showProductsEbookDetail');
    Route::get('ebook/productsEbook/{search}', 'WelcomeController@showProductsEbookAll');
    Route::get('ebook/productsEbook', 'WelcomeController@showProductsEbookAll');

    Route::get('/mini', 'MiniCartController@index');
    Route::post('/mini', 'MiniCartController@show_mini');
    Route::get('/miniHeart', 'MiniCartController@index');
    Route::post('/miniHeart', 'MiniCartController@show_mini_heart');
    Route::resource('profile', 'ProfileController')->middleware('is_user');
    Route::get('ebook/favorBook', 'FavorBookController@indexEbook')->middleware('is_user');
    Route::resource('favorBook', 'FavorBookController')->middleware('is_user');
    // Route::post('/cart/checkOut', 'CheckOutController@index')->middleware('is_user');
    Route::get('/ebook/cart/checkOut', 'CheckOutController@indexEbook')->middleware('is_user');
    Route::get('/ebook/cart', 'TmpCartController@indexEbook')->middleware('is_user');
    Route::resource('cart/checkOut', 'CheckOutController')->middleware('is_user');
    Route::resource('cart', 'TmpCartController')->middleware('is_user');

    Route::resource('order', 'OrderMasFrontController')->middleware('is_user');
    Route::get('/reload-captcha', 'ContactUsController@reloadCaptcha');
    Route::get('/ebook/contact/create', 'ContactUsController@createEbook');
    Route::resource('contact', 'ContactUsController');
    Route::get('admin/contact/{id}', 'ContactUsController@show');
    Route::get('admin/contact', 'ContactUsController@index');
    Route::post('admin/sendEmail', 'ContactUsController@sendEmail');

    Route::get('file/{name}', 'ViewFileController@preView');
    Route::get('fileEbook/{name}', 'ViewFileController@fileEbook');
    Route::get('view/{name}', 'ViewFileController@view');

    Route::get('ebook/{search}', 'WelcomeController@indexEbook');
    Auth::routes();

    // search order 
    Route::get('admin/order/search/{keyword}', function ($keyword) {
        if (Auth::check()) {
            if(Auth::user()->class_user === "admin"){
                return view('order.index', [
                    'keyword' => $keyword
                ]);
            }       
        }
        return redirect('/');
    });
    Route::get('admin/order/status/{status}', function ($status) {
        if (Auth::check()) {
            if(Auth::user()->class_user === "admin"){
                return view('order.index', [
                    'status' => $status
                ]);
            }       
        }
        return redirect('/');
    });
    Route::get('admin/orderEbook/status/{status}', function ($status) {
        if (Auth::check()) {
            if(Auth::user()->class_user === "admin"){
                return view('order-ebook.index', [
                    'status' => $status
                ]);
            }       
        }
        return redirect('/');
    });
    Route::get('admin/approve/status/{status}', function ($status) {
        if (Auth::check()) {
            if(Auth::user()->class_user === "admin"){
                return view('order-ebook.approve', [
                    'status' => $status
                ]);
            }       
        }
        return redirect('/');
    });

    Route::get('admin/home', 'HomeController@index')->name('home')->middleware('is_admin');
    Route::get('admin/dashboard', 'DashboardController@index')->name('dashboard')->middleware('is_admin');
    Route::get('admin/ajaxSelectTwoBestSeller','AjaxSelectTwoController@index')->middleware('is_admin');
    Route::post('admin/ajaxSelectTwoBestSeller','AjaxSelectTwoController@ajaxSelectTwoBestSeller')->middleware('is_admin');
    //Route::get('admin/products/stock', 'ProductStockController@index')->name('stock.index');
    //Route::put('admin/products/stock/{id}/edit', 'ProductStockController@update')->name('stock.update');
    //Route::post('admin/order/trash/{status}', 'OrderMasController@index')->middleware('is_admin');
    //Route::post('admin/order/{status}', 'OrderMasController@index')->middleware('is_admin');
    Route::resource('admin/products/stock', 'ProductStockController')->middleware('is_admin');
    Route::resource('admin/bookCategory', 'BookTypeController')->middleware('is_admin');
    Route::resource('admin/publisher', 'PublisherController')->middleware('is_admin');
    Route::resource('admin/transport', 'TransportController')->middleware('is_admin');
    Route::resource('admin/payment', 'PaymentController')->middleware('is_admin');
    Route::resource('admin/slide', 'SlideController')->middleware('is_admin');
    Route::resource('admin/privacy', 'PrivacyController')->middleware('is_admin');

    Route::resource('admin/ebookConsignment', 'ProductEbookConsignmentController')->middleware('is_admin');
    Route::resource('admin/approve', 'ApproveEbookController')->middleware('is_admin');
    Route::resource('admin/orderEbook', 'OrderMasEbookController')->middleware('is_admin');
    Route::resource('admin/order', 'OrderMasController')->middleware('is_admin');
    Route::resource('admin/payInSlipEbook', 'TranferEbookController')->middleware('is_admin');
    Route::resource('admin/payInSlip', 'TranferController')->middleware('is_admin');
    Route::resource('admin/discount', 'DiscountController')->middleware('is_admin');
    Route::resource('admin/buffet', 'BuffetController')->middleware('is_admin');
    Route::resource('admin/bestSeller', 'BestSellerController')->middleware('is_admin');
    Route::resource('admin/preProducts', 'PreProductController')->middleware('is_admin');
    Route::resource('admin/member', 'MemberController')->middleware('is_admin');
    Route::resource('admin/memberConsignment', 'MemberConsignmentController')->middleware('is_admin');
    Route::resource('admin/productsEbook', 'ProductEbookController')->middleware('is_admin');
    Route::resource('admin/products', 'ProductController')->middleware('is_admin');
    Route::resource('admin/news', 'NewsController')->middleware('is_admin');
    Route::resource('admin/board', 'BoardController')->middleware('is_admin');
    Route::resource('admin/config', 'WebConfigController')->middleware('is_admin');
});


