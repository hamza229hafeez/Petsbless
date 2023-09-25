<?php
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apicontroller;
use App\Http\Controllers\PetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PetsForServiceController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\VendorController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/users', [UserController::class, 'index']);
Route::post('/adduser', [UserController::class, 'store']);
Route::get('/user/{id}', [UserController::class, 'show']);


Route::get('/pets', [PetController::class, 'index']);
Route::post('/addpet', [PetController::class, 'store']);
Route::get('/pet/{id}', [PetController::class, 'show']);
Route::get('/pets/{userId}', [PetController::class, 'getPetsByUserId']);
Route::delete('/pet/{id}', [PetController::class, 'deletePet']);

Route::get('/posts', [PostController::class, 'index']);
Route::post('/addpost', [PostController::class, 'store']);
Route::get('/post/{id}', [PostController::class, 'show']);
Route::get('/userpost/{userId}', [PostController::class, 'getPostsByUserId']);
Route::delete('/post/{id}', [PostController::class, 'deletePost']);

Route::get('/services', [ServiceController::class, 'index']);
Route::post('/services', [ServiceController::class, 'store']);
Route::get('/services/{id}', [ServiceController::class, 'show']);
Route::get('/user-services/{userId}', [ServiceController::class, 'getServicesByUserId']);

//Route::get('/vendors', [VendorController::class, 'index']);
Route::post('/vendor', [VendorController::class, 'store']);
Route::get('/vendor/{id}', [VendorController::class, 'getVendorById']);







//Route::get("/getAllUsers",[Apicontroller::class,'getAllUsers']);

// Route::post("/register",[Apicontroller::class,'register']);
// Route::post("/login",[Apicontroller::class,'login']);

// Route::apiResource('/pets', 'API\PetController');


// Route::get("/getUserData/{id?}",[Apicontroller::class,'getUserData']);
// Route::post("/deleteUserData/{id?}",[Apicontroller::class,'deleteUserData']);
// Route::detete("/UpdateUserData/{id?}",[Apicontroller::class,'updateUserData']);
