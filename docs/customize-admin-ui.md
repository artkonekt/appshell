# Customizing The Admin UI

The user interface was built on top of the [Bootstrap 4.0](https://getbootstrap.com/docs/4.0)
variant of [CoreUI](https://coreui.io/).

The SASS files can be found in the `src/resources/assets/sass/` folder, and the javascript files are
in the `src/resources/assets/js/` folder (under `vendor/konekt/appshell`).

## Modify The Assets Of The Layout

The application author has complete control over what js and css files are included in
the default AppShell layout. This can be done by setting asset URLs in the module configuration.

```php
//config/concord.php
'modules' => [
    Konekt\AppShell\Providers\ModuleServiceProvider::class => [
        'ui' => [
            'assets' => [
                'js'  => ['/js/my.js', '//some-cdn.com/some-library.js'],
                'css' => [
                    '/css/my.css',
                    // You can specify attributes for the generated html tag:
                    'https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css' => [
                        'integrity'   => 'sha256-3sPp8BkKUE7QyPSl6VfBByBroQbKxKG7tsusY2mhbVY=',
                        'crossorigin' => 'anonymous'
                    ]
                ]
            ]
    // ...
```

> AppShell's **default css/js assets** can be found in the `Konekt\AppShell\Assets\DefaultAppShellAssets` class.

### Using A Custom Asset URL Function

> Available from **v1.2.0**

The asset URLs in the layout (js, css) by default are being passed through the Laravel
[asset()](https://laravel.com/docs/5.7/helpers#method-asset) helper function.

You can override this for each asset individually by passing a PHP function name in the
`assetFunction` attribute:

```php
//config/concord.php
'modules' => [
    Konekt\AppShell\Providers\ModuleServiceProvider::class => [
        'assets' => [
            'js'  => [
                '/js/my.js' => [
                    'assetFunction' => 'mix' // Use mix() instead of asset()
                ]
//...
```

## Customizing The Existing CSS

> Read the [Laravel Mix](https://laravel.com/docs/5.7/mix#sass) Documentation for more details about managing frontend assets in your application.

### Additional Application Styles

In case you want use the default AppShell stylesheet, and add moderate customizations to it,
you can modify the build script in your application (mostly webpack + laravel mix).

**Example:**

```js
// webpack.mix.js
mix.js('resources/assets/js/app.js', 'public/js')
    .scripts([
        'public/js/app.js', // Your app's JS
        'vendor/konekt/appshell/src/resources/assets/js/appshell.js'
    ], 'public/js/app.js')
    .sass('vendor/konekt/appshell/src/resources/assets/sass/appshell.sass', 'public/css') // use the default CSS
    .sass('resources/assets/sass/app.sass', 'public/css'); // Your app's SASS
```

**Add the extra CSS to the layout:**

```php
//config/concord.php
use Konekt\AppShell\Assets\DefaultAppShellAssets;

return [
    'modules' => [
        Konekt\AppShell\Providers\ModuleServiceProvider::class => [
            'ui' => [
                'name'   => 'My App',
                'url'    => '/admin/dashboard',
                'assets' => [
                    'js' => DefaultAppShellAssets::JS,
                    'css'=> array_merge(DefaultAppShellAssets::CSS, ['/css/app.css'])
                ]
            ]
        ],
        // ...
    ]
];
```

### Taking Over The Sass Files

Another approach is to copy all the sass files from the
`vendor/konekt/appshell/src/resources/assets/sass/` folder to your application's
`resources/assets/sass/` folder and modify them freely.

**Example:**

```js
// webpack.mix.js
mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/appshell.sass', 'public/css');
```

In this example, the output folder of `appshell.css` file is unchanged, thus no change is needed in
the [asset configuration](#modify-the-assets-of-the-layout).


## Using A Completely Different CSS

It is also possible to not use the default stylesheets at all, but use any other Bootstrap 4
compatible CSS.

See [Modify The Assets Of The Layout](#modify-the-assets-of-the-layout) above.

---

**Next**: [Extending &raquo;](extending.md)
