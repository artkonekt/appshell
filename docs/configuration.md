# AppShell Configuration

AppShell ships with a series of configuration options to improve the interoperability with your
application and to enable customization.

The easiest way to set configuration values is to pass them directly in `config/concord.php`:

```php
return [
    'modules' => [
        Konekt\AppShell\Providers\ModuleServiceProvider::class => [
            'breadcrumbs' => false, // to disable breadcrumbs feature            
        ]
    ]
];
```

## Auth Route Names

AppShell's default theme comes with default views for login, reset password and registration.
These views are the themed versions of the same views in default Laravel installation.

These views rely on a few named routes. These routes typically exist in most Laravel
applications. They are generated by Laravel's auth scaffolding, but these routes may or may not
be present in your application.

Additionally, this functionality (`Auth::routes()`, `artisan make:auth`) was deprecated with Laravel
6 and has been removed from Laravel 7 and moved to the `laravel/ui` composer package.

To change the **names** of these routes, configure these values:

```php
// config/concord.php
return [
    'modules' => [
        Konekt\AppShell\Providers\ModuleServiceProvider::class => [
            'ui' => [
                'routes' => [
                    'login'            => 'login_route', // The `login_route` must be defined with Route::get(...)
                    'logout'           => 'app.custom.logout_route',
                    'register'         => 'app.custom.register_route',
                    'password.request' => 'app.custom.password_request_route',
                    'password.email'   => 'app.custom.password_email_route',
                ]
            ]
        ]
    ]
]; 
```

The routes are used in the following views:

| Route Name           | HTTP Method | Description                        | Used By                                   |
|:---------------------|:------------|:-----------------------------------|:------------------------------------------|
| **login**            | `GET`       | The app's login URL                | - login.blade.php<br>- register.blade.php |
| **logout**           | `POST`      | The app's logout URL               | - _header.blade.php                       |
| **password.request** | `GET`       | Displays the password reset page   | - login.blade.php                         |
| **password.email**   | `GET`       | Sends the password reset link      | - email.blade.php                         |
| **password.request** | `POST`      | Submits the password reset request | - reset.blade.php                         |


---

**Next**: [Admin Panel &raquo;](admin-panel.md)