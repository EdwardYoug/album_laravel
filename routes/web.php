<?php

use App\Http\Controllers\Main\MainController;
use App\Http\Controllers\Albums\AlbumsController;
use App\Http\Controllers\Photos\PhotosController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

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

/*
 * Ресурсный контроллер для этого роута не нужен
 */
Route::get('/', [MainController::class,'index'])->name('main.index');


Route::get('/dashboard', function() {
    return view('dashboard');
})->name('dashboard');


Route::resource('albums',AlbumsController::class)->middleware(['auth']);
Route::resource('photos',PhotosController::class)->middleware(['auth']);