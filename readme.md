# Laravel Aiditokens

[![Latest Stable Version](https://poser.pugx.org/tpenaranda/aiditokens/v/stable)](https://packagist.org/packages/tpenaranda/aiditokens) [![Total Downloads](https://poser.pugx.org/tpenaranda/aiditokens/downloads)](https://packagist.org/packages/tpenaranda/aiditokens) [![License](https://poser.pugx.org/tpenaranda/aiditokens/license)](https://packagist.org/packages/tpenaranda/aiditokens)

A Laravel package to reference Models by using custom string tokens instead of IDs.

## Use cases
- You want to hide ID information on your endpoints. `/api/user/32` ends as `/api/user/5cb0b0dddf8ae37a6e8066d4ffd838d91c94bdc7`.
- You need to create temporary references to your models. For instance, a link for resetting a password that will expire in two hours `reset/password/user/3f6e660c376c9fcaeaddeb50b0893d73e772100f`.

## Installation

Install package using [Composer](http://getcomposer.org).

    $ composer require tpenaranda/aiditokens

Run migrations.

    $ php artisan migrate

## Usage

- Include Tokens trait on desired Laravel model.

```
class User extends Model
{
    use TPenaranda\Aiditokens\Traits\Tokens;
```

- Get (create if necessary) a token:
```
$userModel->getToken();

$userModel->getToken($expireInHours = 2);
```

- Retrieve a model by token:
```
$user = User::firstByToken('5cb0b0dddf8ae37a6e8066d4ffd838d91c94bdc7');

```

- Custom token generation

```
class User extends Model
{
    use TPenaranda\Aiditokens\Traits\Tokens;

    public function generateToken(): string
    {
        return str_random(); // Your custom logic goes here.
    }
```

## Advanced usage
- Bind on RouteServiceProvider for route model explicit binding

```
class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::pattern('userToken', '^.{40}$');

        Route::bind('userToken', function ($value) {
            $modelToken = ModelToken::whereValue($value)->whereModelType(User::class)->where(function ($query) {
                $query->whereNull('expire_at')->orWhere('expire_at', '>', now());
            })->first();

            return User::firstByToken($value) ?? abort(404);
        });
```

- Route file
```
Route::get('users/{userToken}', 'UserController@get');
```

Happy coding!