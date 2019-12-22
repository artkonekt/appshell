# Change Admin URL Prefix

The routes defined by AppShell are located by default under `/admin/xyz`

You can change the `/admin` prefix in your application to an arbitrary one.
This can be done by setting the prefix of the routes in the module configuration (`config/concord/php`).

This Example changes `/admin` to `/manage`:

```php
//config/concord.php
'modules' => [
    Konekt\AppShell\Providers\ModuleServiceProvider::class => [
        // ...
        'routes' => [
            [
                'prefix'     => 'manage',
                'as'         => 'appshell.',
                'middleware' => ['web', 'auth', 'acl'],
                'files'      => ['acl']
            ],
            [
                'prefix'     => 'manage',
                'as'         => 'appshell.',
                'middleware' => ['web', 'auth'],
                'files'      => ['nonacl']
            ],
        ],
        // ...
```

---

**Next**: [Using Custom Models &raquo;](models.md)
