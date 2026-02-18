<?php

use App\Http\Controllers\ScrapingController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**Aqui he definido cada una de las rutas que debe tener mi programa, entonces usamos 
 * get para traer, post para crear, put para actualizar y delete para borrar, es importante tener en cuenta
 * que todos estos procesos salen del mismo RESOURCES del controlador que serian los index, store, show, updated y demas
 * 
 * Para la api del scrapping lo que hacemos es llamar el scrapingcontroller.
 */
Route::get('/tasks',[TaskController::class, 'index']);
Route::post('/tasks',[TaskController::class, 'store']);
Route::get('/tasks/{task}',[TaskController::class, 'show']);
Route::put('/tasks/{task}',[TaskController::class, 'update']);
Route::delete('/tasks/{task}',[TaskController::class, 'destroy']);

Route::get('/scraping', ScrapingController::class);
