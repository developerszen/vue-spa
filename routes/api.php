<?php

Route::post('auth/login', 'AuthController@login');

Route::middleware(['auth:api'])->group(function () {
    Route::get('auth/me', 'AuthController@me');
    Route::post('auth/logout', 'AuthController@logout');

    Route::get('books/resources',            'BookController@resources');
    Route::get('books/{book}/edit',          'BookController@edit');
    Route::get('authors/{author}/edit',      'AuthorController@edit');
    Route::get('categories/{category}/edit', 'CategoryController@edit');

    Route::apiResources([
        'authors' =>    'AuthorController',
        'categories' => 'CategoryController',
        'books' =>      'BookController',
    ]);

    Route::get('validators/unique', 'ValidatorController@unique');
});
