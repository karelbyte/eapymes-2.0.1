<?php
/*'middleware' => 'auth'*/
Route::group(['middleware' => 'auth'], function () {


get('/', function () {
    return view('app.home');
});

get('/pruebas', function () {
    return view('pruebas');
});

// route help
post('/helps/showhelpoff', 'Userhelp_Controller@showhelpoff');
get('/helps/showhelp', 'Userhelp_Controller@showhelp');

// route measures
get('measures/lists', 'Measures_Controller@lists');
resource('measures','Measures_Controller');

// route categories
get('categories/lists', 'Categories_Controller@lists');
resource('categories','Categories_Controller');

// route taxs
get('taxs/lists', 'Taxs_Controller@lists');
resource('taxs','Taxs_Controller');

// route discounts
get('discounts/lists', 'Discounts_Controller@lists');
resource('discounts','Discounts_Controller');


// route products
get('/products/lists', 'Products_Controller@lists');
get('/products/taxs/{id}', 'Products_Controller@taxs');
post('/products/taxs/stores', 'Products_Controller@taxsstores');
get('/products/discounts/{id}', 'Products_Controller@discounts');
post('/products/discounts/stores', 'Products_Controller@discountstores');
resource('products','Products_Controller');

// route ingredients
get('/ingredients/lists/{id}','Products_Ingredients_Controller@ingredients');
get('/ingredients/product/list/{id}','Products_Ingredients_Controller@product_ingredients');
resource('ingredients','Products_Ingredients_Controller');


// routes persons
post('persons/imgstore', 'Persons_Controller@saveimg');
get('/persons/lists', 'Persons_Controller@lists');
resource('persons','Persons_Controller');

// routes profiles
get('/profiles/lists', 'Profiles_Controller@lists');
resource('profiles','Profiles_Controller');

// routes users
get('/users/lists', 'Users_Controller@lists');
resource('users','Users_Controller');

// routes storehouses
get('/stores/lists', 'Stores_Controller@lists');
resource('stores','Stores_Controller');

// routes storehouses
get('/opens/lists', 'Opens_Controller@lists');
resource('opens','Opens_Controller');
    
});// routes storehouses
get('/shelves/lists', 'Shelves_Controller@lists');
resource('shelves','Shelves_Controller');


// Rutas independientes
get('/auth/login', [
    'as'=>'login',
    'uses'=>'Auth\AuthController@getLogin'
]);

post('auth/login', [
    'as'=>'login',
    'uses'=>'Auth\AuthController@postLogin'
]);

get('auth/logout', 'Auth\AuthController@getLogout');