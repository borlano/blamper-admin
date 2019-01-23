<?php

Route::get('', ['as' => 'admin.dashboard', function () {
    $content = '';
    return AdminSection::view($content, '');
}]);

Route::post('/publications/create', 'App\Admin\Http\Controllers\PublicationController@createPublication')->name('admin.create.publication');

Route::post('/subjects/create', 'App\Admin\Http\Controllers\SubjectController@createSubject')->name('admin.create.subject');