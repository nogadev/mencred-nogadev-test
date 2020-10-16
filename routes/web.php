<?php

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

Route::get('/', function () {
    return redirect(route('login'));
});

Route::group(['middleware' => 'auth'], function (){
    //CRUD Utils
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('users', 'UserController');
    //Geography
    //Countries
    Route::resource('countries', 'CountryController');
    Route::patch('/countries/{country}/restore', 'CountryController@restore')->name('countries.restore');
    Route::post('/countries/provinces', 'CountryController@provincesAjax')->name('country.provinces');
    //Provinces
    Route::resource('provinces', 'ProvinceController');
    Route::patch('/provinces/{province}/restore', 'ProvinceController@restore')->name('provinces.restore');
    Route::post('/provinces/districts', 'ProvinceController@districtsAjax')->name('province.districts');
    //Districts
    Route::resource('districts', 'DistrictController');
    Route::patch('/districts/{district}/restore', 'DistrictController@restore')->name('districts.restore');
    Route::post('/districts/towns', 'DistrictController@townsAjax')->name('district.towns');
    //Towns
    Route::resource('towns', 'TownController');
    Route::patch('/towns/{town}/restore', 'TownController@restore')->name('towns.restore');
    Route::post('/towns/neighborhoods', 'TownController@neighborhoodsAjax')->name('town.neighborhoods');
    //Neighborhoods
    Route::resource('neighborhoods', 'NeighborhoodController');
    Route::patch('/neighborhoods/{neighborhood}/restore', 'NeighborhoodController@restore')->name('neighborhoods.restore');
    //Commerces
    Route::resource('commerces', 'CommerceController');
    Route::patch('/commerces/{commerce}/restore', 'CommerceController@restore')->name('commerces.restore');
    //Deliveries
    Route::resource('deliveries', 'DeliveryController');
    Route::patch('/deliveries/{delivery}/restore', 'DeliveryController@restore')->name('deliveries.restore');
    Route::post('/deliveries/get-by-id', 'DeliveryController@getById')->name('deliveries.getById');
    Route::post('/deliveries/fast-store', 'DeliveryController@fastStore')->name('deliveries.fastStore');
    //Route
    Route::resource('routes', 'RouteController');
    Route::patch('/routes/{route}/restore', 'RouteController@restore')->name('routes.restore');
    //Kinships
    Route::resource('kinships', 'KinshipController');
    Route::patch('/kinships/{kinship}/restore', 'KinshipController@restore')->name('kinships.restore');
    //Article Categories
    Route::resource('articleCategories', 'ArticleCategoryController');
    Route::patch('/articleCategories/{articleCategory}/restore', 'ArticleCategoryController@restore')->name('articleCategories.restore');
    Route::post('/articleCategories/attributes', 'ArticleCategoryController@attributesAjax')->name('articleCategories.attributes');
    //Sellers
    Route::resource('sellers', 'SellerController');
    Route::patch('/sellers/{seller}/restore', 'SellerController@restore')->name('sellers.restore');
    Route::post('/sellers/get-by-id', 'SellerController@getById')->name('sellers.getById');
    Route::post('/sellers/fast-store', 'SellerController@fastStore')->name('sellers.fastStore');
    //Visit Days
    Route::resource('visitDays', 'VisitDayController');
    Route::patch('/visitDays/{visitDay}/restore', 'VisitDayController@restore')->name('visitDays.restore');
    //Stores
    Route::resource('stores', 'StoreController');
    Route::patch('/stores/{store}/restore', 'StoreController@restore')->name('stores.restore');
    Route::post('/stores/fast-store', 'StoreController@fastStore')->name('stores.fastStore');
    //Companies
    Route::resource('companies', 'CompanyController');
    Route::patch('/companies/{company}/restore', 'CompanyController@restore')->name('companies.restore');
    Route::post('/companies/fast-store', 'CompanyController@fastStore')->name('companies.fastStore');
    //Suppliers
    Route::resource('suppliers', 'SupplierController');
    Route::patch('/suppliers/{supplier}/restore', 'SupplierController@restore')->name('suppliers.restore');
    Route::post('/suppliers/get-by-id', 'SupplierController@getById')->name('suppliers.getById');
    Route::post('/suppliers/fast-store', 'SupplierController@fastStore')->name('suppliers.fastStore');
    //Travelers
    Route::resource('travelers', 'TravelerController');
    Route::patch('/travelers/{traveler}/restore', 'TravelerController@restore')->name('travelers.restore');
    //Customers
    Route::resource('customers', 'CustomerController');
    Route::patch('/customers/{supplier}/restore', 'CustomerController@restore')->name('customers.restore');
    Route::post('/customers/get-by-id', 'CustomerController@getById')->name('customers.getById');
    Route::post('/customers/fast-store', 'CustomerController@fastStore')->name('customers.fastStore');
    //Articles
    Route::resource('articles', 'ArticleController');
    Route::get('/articles/{article}/restore', 'ArticleController@restore')->name('articles.restore');
    Route::post('/articles/get-by-code', 'ArticleController@getByCode')->name('articles.getByCode');
    Route::post('/articles/fast-store', 'ArticleController@fastStore')->name('articles.fastStore');
    Route::post('/articles/fast-update-price', 'ArticleController@fastUpdatePrice')->name('articles.fastUpdatePrice');
    Route::post('/articles/upload', 'ArticleController@upload')->name('articles.upload');
    Route::get('/articles/{article}/destroy', 'ArticleController@destroy')->name('articles.destroy');
    Route::get('/article', 'ArticleController@findById')->name('articles.findById');
    //Inventory
    Route::get('/inventory', 'ArticleStocksController@inventory')->name('inventory');
    Route::get('/articlestocks/setstock', 'ArticleStocksController@setStock')->name('articlestocks.setstock');
    Route::get('/articlestocks/inventory', 'ArticleStocksController@inventory')->name('articlestocks.inventory');
    //Prices
    Route::get('/prices', 'ArticleController@prices')->name('articles.prices.index');
    Route::resource('attributes', 'AttributeController');
    Route::patch('/attributes/{attribute}/restore', 'AttributeController@restore')->name('attributes.restore');
    //Price New
    Route::post('/prices/store' , 'ArticlePriceController@store')->name('articleprice.store');
    Route::post('/prices/article' , 'ArticlePriceController@findByArticle')->name('articleprice.article');
    Route::get('/prices/pointofsale' , 'ArticlePriceController@findByPriceByPointOfSale')->name('articles.price.pointofsale');
    //Price Destroy
    Route::delete('/prices/destroy' , 'ArticlePriceController@destroy')->name('articles.price.destroy');
    //Buys
    Route::get('/buys/report-form', 'BuyController@showReportForm')->name('buys.report-form');
    Route::get('/buys/report-form/data', 'BuyController@getReportFormData')->name('buys.report-form.data');
    Route::resource('buys', 'BuyController');
    //Stock Transfers
    Route::get('/stocks/transfer', 'StockController@transfer')->name('stocks.transfer');
    Route::post('/stocks/save-transfers', 'StockController@saveTransfers')->name('stocks.saveTransfers');
    Route::resource('stocks', 'StockController');
    Route::get('/articleStocks/get-by-store-and-company','ArticleStocksController@getByStoreAndCompany')->name('articleStocks.getByStoreAndCompany');
    Route::get('/articleStocks/get-by-store-article','ArticleStocksController@getByStoreAndId')->name('articleStocks.getByStoreAndId');
    Route::post('/articleStocks/get-article-prices','ArticleStocksController@getArticlePrices')->name('articleStocks.getArticlePrices');
    Route::post('/articleStocks/store-prices', 'ArticleStocksController@storePrices')->name('articleStocks.prices.store');
    //Credits
    Route::resource('credits', 'CreditController');
    Route::get( '/changeStatusCredit'   , 'CreditController@changeStatus')->name('credits.changeStatus');
    Route::get( '/collection'           , 'CreditController@collect'     )->name('credits.collection');
    Route::get( '/getCollect'           , 'CreditController@getCollect'  )->name('credits.getCollect');
    Route::post('/storeCollect'         , 'CreditController@storeCollect')->name('credits.storeCollect');
    Route::post('/updateFee'            , 'CreditController@updateFee'   )->name('credits.updateFee');
    Route::post('updateObservation'     ,  array('as' => 'updateObservation' , 'uses' => 'CreditController@updateObservation'));
    Route::get( 'feesJson'              ,  array('as' => 'feesJson'   , 'uses' => 'CreditController@feeJson'));
    Route::get( 'creditJson'            ,  array('as' => 'creditJson' , 'uses' => 'CreditController@json'));
    //Customers
    Route::resource('customers', 'CustomerController');
    Route::patch('/customers/{customer}/restore', 'CustomerController@restore')->name('customers.restore');
    Route::post('/customers/get-by-id', 'CustomerController@getById')->name('customers.getById');
    Route::post('/customers/fast-store', 'CustomerController@fastStore')->name('customers.fastStore');
    //Sequence
    Route::get('/sequence'      , 'CustomerController@sequence'     )->name('customers.sequence');
    Route::get('/sequence/data' , 'CustomerController@getSequence'  )->name('customers.sequence.data');
    Route::post('/sequence'     , 'CustomerController@storeSequence')->name('customers.sequence.save');
    //MovReasons
    Route::resource('movreasons', 'MovReasonController');
    //Cash
    Route::resource('cashes', 'CashController');
    Route::get('/cashactual', 'CashController@create')->name('cash.actual');
    Route::post('/storeMovement', 'CashController@storeMovement')->name('cashes.storeMovement');
    Route::post('/destroyMovement', 'CashController@destroyMovement')->name('cashes.destroyMovement');
    Route::get('/cashopen', 'CashController@openCash')->name('cash.open');
    Route::get('/cashclose', 'CashController@closeCash')->name('cash.close');
    Route::get('/mpavailable', 'CashController@getAmountAvailableMercadoPago')->name('cash.mp.available');
    Route::get('/cashfromdate', 'CashController@getCashFromDate')->name('cash.date');
    Route::get('/cashbydate', 'CashController@index')->name('cashes.index');
    Route::get('/cashcheck', 'CashController@getMovsByCheck')->name('cash.check');
    //Claims
    Route::get('claimsJson', array('as' => 'claimsJson', 'uses' => 'ClaimController@json'));
    Route::post('/claimResolv', 'ClaimController@resolv')->name('claim.resolv');
    Route::post('/claimStore', 'ClaimController@store')->name('claim.store');
    Route::post('/claimTrakingStore', 'ClaimController@trakingStore')->name('claim.trakingStore');
    //Expenses
    Route::get('expenses', 'ExpensesController@create')->name('expenses');
    Route::post('/storeExpense', 'ExpensesController@store')->name('expenses.storeExpense');
    //Payments
    Route::post('/storepaymentdetails', 'PaymentController@store')->name('payment.set.details');
    Route::post('/destroypaymentdetails', 'PaymentController@destroy')->name('payment.destroy');
    Route::post('/updatecheck', 'PaymentController@updateCheck')->name('payment.update.check');

    //Reports Views
    //Articles Stock
    Route::get('/stock/list'      , 'ArticleStocksController@findStockList')->name('stock.list');
    Route::get('/stock/list/data' , 'ArticleStocksController@findStockData')->name('stock.list.data');
    //Articles Price List
    Route::get('/price/list'      , 'ArticleController@showPriceList')->name('price.list');
    Route::get('/price/list/data' , 'ArticleController@findPriceListData')->name('price.list.data');
    //ArticlePrice
    Route::post('/prices/store' , 'ArticlePriceController@store')->name('articleprice.store');

    //Credits Total General
    Route::get( '/total'          , 'CreditController@showCreditTotal')->name('credits.total');
    Route::get( '/total/data'     , 'CreditController@getCreditsByRoute')->name('credits.total.route');
    // General Sales
    Route::get('/sales/general'        , 'SalesController@showGeneralSales' )->name('sales.general');
    Route::get('/sales/general/data'   , 'SalesController@getGeneralSales' )->name('sales.general.data');
    Route::post('/sales/general/data'   , 'SalesController@markAsInvoiced' )->name('sales.general.markinvoiced');
    //Payments Sellers
    Route::get('/payments/sellers'     , 'SalesController@showPaymentSeller' )->name('payments.sellers');
    Route::get('/payments/sellers/data', 'SalesController@getPaymentsBySeller' )->name('payments.sellers.data');
    //Claims
    Route::get('/claims'      , 'ClaimController@showClaimsReport'  )->name('claims.list');
    Route::get('/claims/data' , 'ClaimController@getClaimsByStatus' )->name('claims.list.data');
    //Cashes
    Route::get('/cashes'      , 'CashController@showCashReport'  )->name('cash.list');
    Route::get('/cashesinfo' , 'CashController@getCashDetail'   )->name('cash.list.data');

    //Reports Print
    Route::get('/print/customers' , 'API\CustomerController@findAll' )->name('print.customers.all');
    Route::get('/print/customers/sequence/{route_id}' , 'API\CustomerController@sequence' )->name('print.customers.sequence');
    Route::get('/print/credit/detail/{credit_id}' , 'API\CreditController@findDetailById')->name('print.credit.detail');
    Route::get('/print/credit/card/{credit_id}' , 'API\CreditController@findCardById' )->name('print.credit.card');
    Route::get('/print/articles/stock/list' , 'API\ArticleStocksController@printStockList' )->name('print.articles.stock.list');
    Route::get('/print/articles/price/list' , 'API\ArticleStocksController@printPriceList' )->name('print.articles.price.list');
    Route::get('/print/credit/collection' , 'API\CreditController@getCollection' )->name('print.credit.collection');
    Route::get('/print/credits/total' , 'API\CreditController@getCreditsByRoute' )->name('print.credits.route');
    Route::get('/print/sales/general', 'API\SalesController@getGeneralSales' )->name('print.sales.general');
    Route::get('/print/payments/sellers', 'API\SalesController@getPaymentsBySeller' )->name('print.payments.sellers');
    Route::get('/print/claims' , 'API\ClaimController@getClaimsByStatus' )->name('print.claims');
    Route::get('/print/claim/{id}' , 'API\ClaimController@getClaimByCredit' )->name('print.claim.credit');
    Route::get('/print/cashes' , 'API\CashController@getDetails' )->name('print.cashes');
    Route::get('/print/bought-articles', 'API\BoughtController@getReportBought')->name('print.bought.articles');
});

Auth::routes();
