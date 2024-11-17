<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionaryFormController;

Route::get('/', function () {
    return view('questionary');
});

Route::prefix('api')->group(function () {
    Route::get('/form', [QuestionaryFormController::class, 'getFormFields']);
    Route::post('/form/submit', [QuestionaryFormController::class, 'submitForm']);
});
