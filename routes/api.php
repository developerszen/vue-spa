<?php

Route::post('login', 'AuthController@login');

Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', 'AuthController@logout');

    Route::get('books/resources',            'BookController@resources');
    Route::get('books/{book}/edit',          'BookController@edit');
    Route::get('authors/{author}/edit',      'AuthorController@edit');
    Route::get('categories/{category}/edit', 'CategoryController@edit');

    Route::apiResources([
        'authors' =>    'AuthorController',
        'categories' => 'CategoryController',
        'books' =>      'BookController',
    ]);
});