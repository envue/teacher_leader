<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('roadmap', 'RoadmapController@index')->name('roadmap');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::resource('users', 'UsersController');

    // Time Work Types
    Route::delete('time-work-types/destroy', 'TimeWorkTypeController@massDestroy')->name('time-work-types.massDestroy');
    Route::resource('time-work-types', 'TimeWorkTypeController');

    // Time Projects
    Route::delete('time-projects/destroy', 'TimeProjectController@massDestroy')->name('time-projects.massDestroy');
    Route::resource('time-projects', 'TimeProjectController');

    // Time Entries
    Route::delete('time-entries/destroy', 'TimeEntryController@massDestroy')->name('time-entries.massDestroy');
    Route::resource('time-entries', 'TimeEntryController');

    // Time Reports
    Route::delete('time-reports/destroy', 'TimeReportController@massDestroy')->name('time-reports.massDestroy');
    Route::resource('time-reports', 'TimeReportController');

    // Time Population Types
    Route::delete('time-population-types/destroy', 'TimePopulationTypeController@massDestroy')->name('time-population-types.massDestroy');
    Route::resource('time-population-types', 'TimePopulationTypeController');

    // Time Caseload Types
    Route::delete('time-caseload-types/destroy', 'TimeCaseloadTypeController@massDestroy')->name('time-caseload-types.massDestroy');
    Route::resource('time-caseload-types', 'TimeCaseloadTypeController');

    //Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
    Route::get('system-calendar/getevents', 'SystemCalendarController@getEvents')->name('system-calendar.getevents');
    Route::match(['put', 'patch'], 'system-calendar/form_update/{id}','SystemCalendarController@formUpdate');
    Route::resource('system-calendar', 'SystemCalendarController');

});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
// Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
        Route::post('googlecalendarid','ChangePasswordController@updateGoogleCalendarId')->name('password.updateGoogleCalendarId');
        Route::post('settings','ChangePasswordController@updateHiddenWorkTypes')->name('password.updateHiddenWorkTypes');
    }
});
