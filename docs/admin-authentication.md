# Authentication

AppShell's authentication completely relies on
[Laravel Authentication](https://laravel.com/docs/8.x/authentication).

Thus there's no additional functionality implemented in this module, all the related
[routes, controllers, middleware, etc](https://laravel.com/docs/8.x/authentication#authentication-quickstart)
has to be done by the host application (ie. your app).

AppShell only contains very tiny extensions to the stock Laravel authentication system:

- Additional user table fields
- Automatic login counter
- Auth views with AppShell look&feel

## Additional User Table Fields

The underlying [user module](https://github.com/artkonekt/user) adds the following fields to the
user table:

- `type` - `Konekt\User\Models\UserType`
- `is_active` - bool
- `last_login_at` - datetime
- `login_count` - integer

## Automatic Login Count

Whenever a login event happens in the system, the `UpdateUserLoginData` listener will update the
`last_login_at` and `login_count` fields.

This feature is enabled by default, but can be disabled. If the `konekt.app_shell.disable.login_counter`
configuration value is false, then no counting will happen.

To disable the feature add this to the module config:

**config/concord.php:**
```php
//...
'modules' => [
    Konekt\AppShell\Providers\ModuleServiceProvider::class => [
        'disable' => [
            'login_counter' => true
        ],
    //...
```

> If the [module event listener bindings](https://artkonekt.github.io/concord/#/event-listener-bindings)
> are turned off, login counter will be disabled, independently from the value of
> `disable.login_counter`

## Auth Views With AppShell Look&Feel

When you run `php artisan make:auth` in your application, Laravel will generate login, register and
password reset views in the `resources/views/auth/` folder.

These views have a plain Bootstrap4 look. AppShell provides the very same forms with AppShell look&feel.

To get these views in your app, use this command:

```bash
php artisan vendor:publish --provider='Konekt\AppShell\Providers\ModuleServiceProvider' --tag=auth-views
```

> The command will not overwrite existing files, unless you pass the *--force* flag to it.

---

**Next**: [ACL &raquo;](acl.md)
