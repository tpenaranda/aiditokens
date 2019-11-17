Route::pattern('userToken', '^.{40}$');

Route::bind('userToken', function ($value) {
    $modelToken = ModelToken::whereValue($value)->whereModelType(User::class)->where(function ($query) {
        $query->whereNull('expire_at')->orWhere('expire_at', '>', now());
    })->first();

    return $modelToken ? $modelToken->model : abort(404);
});

Route::get('users/{userToken}/surveys', 'UserController@getSurveys');