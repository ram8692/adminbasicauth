<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

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

// routes/web.php 

// Display a list of all users
Route::get('/users', [UsersController::class, 'index'])->name('users.index'); 

// Show form to create a new user
Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');

// Store a new user in the database 
Route::post('/users/save', [UsersController::class, 'store'])->name('users.store');

// Show a specific user by ID
Route::get('/users/{id}', [UsersController::class, 'show'])->name('users.show'); 

// Show form to edit an existing user 
Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');

// Update an existing user in the database
Route::put('/users/{id}/update', [UsersController::class, 'update'])->name('users.update'); 

// Delete a user
Route::delete('/users/{id}/delete', [UsersController::class, 'destroy'])->name('users.destroy');
