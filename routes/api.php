<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeerGroupController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/me', [AuthController::class, 'me']);

Route::get('/users', [AuthController::class, 'users']);

Route::get('/peer-groups', [PeerGroupController::class, 'index'])->name('peer_groups.index');

Route::post('/peer-groups', [PeerGroupController::class, 'store'])->name('peer_groups.store');

Route::get('/peer-groups/{peerGroup}', [PeerGroupController::class, 'show'])->name('peer_groups.show');

Route::put('/peer-groups/{peerGroup}', [PeerGroupController::class, 'update'])->name('peer_groups.update');

Route::delete('/peer-groups/{peerGroup}', [PeerGroupController::class, 'destroy'])->name('peer_groups.destroy');

Route::post('/peer-groups/{peerGroup}/attach', [PeerGroupController::class, 'attach'])->name('peer_groups.attach');

Route::post('/peer-groups/{peerGroup}/detach', [PeerGroupController::class, 'detach'])->name('peer_groups.detach');

Route::resource('peer-groups.surveys', SurveyController::class);

Route::resource('peer-groups.surveys.categories', CategoryController::class);

// Route::get('/ratings', [RatingController::class, 'index'])->name('ratings.index');

// Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');

// Route::get('/ratings/{rating}', [RatingController::class, 'show'])->name('ratings.show');

// Route::put('/ratings/{rating}', [RatingController::class, 'update'])->name('ratings.update');

// Route::delete('/ratings/{rating}', [RatingController::class, 'destroy'])->name('ratings.destroy');

Route::resource('peer-groups.surveys.ratings', RatingController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
