<?php

use Illuminate\Support\Facades\Route;

/** Auth Routes */
Route::prefix("auth")->group(function(){
    Route::post("/register", "AuthController@register");
    Route::post("/login", "AuthController@login");
    Route::post("/change-password", "AuthController@changePassword");
});

/** Modules Routes */
Route::prefix("module")->group(function(){
    Route::get("/get-modules", "ModulesController@getModules")->middleware("auth:api");
    Route::get("/get-user-progress", "ModulesController@getUserProgress")->middleware("auth:api");
    Route::get("/get-module-section/{id}", "ModulesController@getModuleSection");
    Route::get("/get-questions/{id}", "ModulesController@getQuestions");
    Route::get("/set-modules-final", "ModulesController@setSectionAndModule")->middleware("auth:api");
    Route::post("/save-section/{user_id}", "ModulesController@saveSection");
});
