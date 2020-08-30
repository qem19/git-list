<?php

use Illuminate\Support\Facades\Route;

Route::prefix('repositories')
    ->group(function () {
        Route::get('/', 'RepositoriesController@index')->name('indexRepository');
        Route::post('/sync', 'RepositoriesController@sync')->name('syncRepository');
        Route::get('/{repository}', 'RepositoriesController@commits')->name('commits');
    });

Route::delete('/commits', 'CommitsController@deleteByIds')->name('deleteByIds');
