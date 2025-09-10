<?php

use App\Http\Controllers\CarreraController;
use App\Http\Controllers\MateriaController;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/saludo', function (Request $request) {
    return response()->json(['mensaje' => 'Hola Mundo']);
});

/*Route::get('/carreras', [CarreraController::class, 'index']);
route::get('/carrerasConMaterias', [CarreraController::class, 'showConMaterias']);
route::post('/carreras', [CarreraController::class, 'store']);
Route::put('/carreras/{id}', [CarreraController::class, 'update']);
route::delete('/carreras/{id}', [CarreraController::class, 'destroy']);*/

Route::apiResource('carreras', carreraController::class);
route::get('/carrerasConMaterias', [CarreraController::class, 'showConMaterias']);

Route::get('/materias', [MateriaController::class, 'index']);
route::post('/materias', [MateriaController::class, 'store']);
Route::apiResource('materias', materiaController::class);
