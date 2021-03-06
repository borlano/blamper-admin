<?php

Route::get('', ['as' => 'admin.dashboard', function () {
    $content = '';
    return AdminSection::view($content, '');
}]);

Route::post('/publications/create', 'App\Admin\Http\Controllers\PublicationController@createPublication')->name('admin.create.publication');
Route::post('/publications/{id}/edit', 'App\Admin\Http\Controllers\PublicationController@editPublication')->name('admin.edit.publication');

Route::post('/subjects/create', 'App\Admin\Http\Controllers\SubjectController@createSubject')->name('admin.create.subject');
Route::post('/subjects/{id}/edit', 'App\Admin\Http\Controllers\SubjectController@editSubject')->name('admin.edit.subject');

//Route::post('/auto_marks/create', 'App\Admin\Http\Controllers\AutoMarkController@createAutoMark')->name('admin.create.automark');
//Route::post('/auto_marks/{id}/edit', 'App\Admin\Http\Controllers\AutoMarkController@editAutoMark')->name('admin.edit.automark');

//Route::post('/auto_models/create', 'App\Admin\Http\Controllers\AutoModelsController@createAutoModels')->name('admin.create.automodels');
//Route::post('/auto_models/{id}/edit', 'App\Admin\Http\Controllers\AutoModelsController@editAutoModels')->name('admin.edit.automodels');

Route::post('/users/{id}/edit', 'App\Admin\Http\Controllers\UserController@editUser')->name('admin.edit.user');

Route::get('/block', 'App\Admin\Http\Controllers\UserController@blockUser')->name('admin.block.user');
Route::get('/unblock', 'App\Admin\Http\Controllers\UserController@unblockUser')->name('admin.unblock.user');