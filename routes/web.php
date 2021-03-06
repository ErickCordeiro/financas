<?php

use App\Http\Controllers\Clients\AppController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

//Routers Web
Route::get('/', [App\Http\Controllers\Web\HomeController::class, 'index'])->name('web.home');

//Routers App
Route::prefix('/app')->middleware(['auth', 'client'])->group(function(){
    //Filter invoices
    Route::any('/invoice/search', [\App\Http\Controllers\Clients\AppController::class, 'search'])->name('app.search');

    //Categories
    Route::get('/categorias', [App\Http\Controllers\Clients\CategoriesController::class, 'index'])->name('app.categories');
    Route::get('/categoria/nova', [App\Http\Controllers\Clients\CategoriesController::class, 'create'])->name('app.categories.create');
    Route::post('/categoria/nova', [App\Http\Controllers\Clients\CategoriesController::class, 'store'])->name('app.categories.store');
    Route::get('/categorias/{id}/editar', [App\Http\Controllers\Clients\CategoriesController::class, 'edit'])->name('app.categories.edit');
    Route::put('/categorias/{id}/editar', [App\Http\Controllers\Clients\CategoriesController::class, 'update'])->name('app.categories.update');
    Route::delete('/categorias/{id}/destroy', [App\Http\Controllers\Clients\CategoriesController::class, 'destroy'])->name('app.categories.destroy');

    Route::get('/controle', [App\Http\Controllers\Clients\AppDashboardController::class, 'index'])->name('app.dash');
    Route::post('/launch', [App\Http\Controllers\Clients\AppController::class, 'launch'])->name('app.launch');
    Route::get('/receitas', [App\Http\Controllers\Clients\AppController::class, 'income'])->name('app.income');
    Route::get('/despesas', [App\Http\Controllers\Clients\AppController::class, 'expense'])->name('app.expense');
    Route::get('/fixas', [App\Http\Controllers\Clients\AppController::class, 'fixed'])->name('app.fixed');

    //Wallets
    Route::get('/carteiras', [App\Http\Controllers\Clients\WalletController::class, 'index'])->name('app.wallets');
    Route::post('/carteiras', [App\Http\Controllers\Clients\WalletController::class, 'store'])->name('app.store.wallets');
    Route::delete('/carteiras/{id}', [App\Http\Controllers\Clients\WalletController::class, 'destroy'])->name('app.delete.wallets');

    //Subscribe
    Route::get('/assinaturas', [App\Http\Controllers\Clients\SignatureController::class, 'index'])->name('app.signature');

    //Update Invoice
    Route::get('/invoice/{id}', [App\Http\Controllers\Clients\AppController::class, 'invoice'])->name('app.invoice');
    Route::put('/invoice/{id}', [App\Http\Controllers\Clients\AppController::class, 'updateInvoice'])->name('app.update.invoice');
    
    //Delete Invoice
    Route::delete('/invoice/{id}', [App\Http\Controllers\Clients\AppController::class, 'destroy'])->name('app.delete.invoice');

    //Profile User Update
    Route::get('/perfil', [App\Http\Controllers\Clients\UserController::class, 'show'])->name('app.profile');
    Route::put('/perfil', [App\Http\Controllers\Clients\UserController::class, 'update'])->name('app.update.profile');

});

//Routers Admin
Route::prefix('/admin')->middleware(['auth', 'admin'])->group(function(){
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('admin.dash');
});