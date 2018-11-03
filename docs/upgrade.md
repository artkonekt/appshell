# Upgrading

## 0.9 -> 1.0

## AppShell Scripts

AppShell's default html layout after v1.0 looks for the `/js/appshell.js` script.

Also beginning with v1.0 it's possible to [configure](customize-admin-ui.md)
what assets (js/css) to include in the layout.

Previous AppShell version layouts were looking for `/js/app.js`.

In case you have an existing application on top of AppShell v0.9 then your app's
`webpack.mix.js` most probably compiled `appshell.js` into the final app.js file.

**Example Old (v0.9) Mix File:**

```js
mix
//...
.js('resources/assets/js/app.js', 'public/js')
.scripts([
    'public/js/app.js',
    'vendor/konekt/appshell/src/resources/assets/js/appshell.js'
], 'public/js/app.js')
//...
```

As a result, AppShell's scripts were included in the final `app.js` file.

After upgrading to v1.0, you have the following opportunities:

1. Keep everything in `app.js` and change the asset config.
2. Change your app's `webpack.mix.js` to output the js as `appshell.js`.
3. Use the standalone appshell script.
4. Something else.

### Keep app.js And Change Config

This solution is the most backwards compatible, it will actually result in the setup of v0.9.

1. Leave the app's `webpack.mix.js` intact.
2. Modify the `config/concord.php` file as follows:

```php
//...
'modules' => [
    Konekt\AppShell\Providers\ModuleServiceProvider::class => [
        'ui' => [
            'name' => 'My App',
            'url' => '/admin/product',
            // Add the following 4 lines
            'assets' => [
                'js'  => ['js/app.js'],
                'css' => \Konekt\AppShell\Assets\DefaultAppShellAssets::CSS
            ]
        ]
    ],
//...
```

### Change Mix To Compile To appshell.js

> This solution is favorable if you need some code in your app's local `resources/js/app.js` file.

Modify `webpack.mix.js` as follows:

```js
//...
// Change the output file name by modifying the
// last parameter of script() method from `app.js` => `appshell.js
.scripts([
    'public/js/app.js',
    'vendor/konekt/appshell/src/resources/assets/js/appshell.js'
], 'public/js/appshell.js') // <- here
//...
```

### AppShell Standalone

Alternatively you can also use new standalone variant of appshell.js.
This variant encapsulates all the necessary dependencies.

To do so, change `webpack.mix.js` as follows:

```js
mix //...
// Add this line:
.js('vendor/konekt/appshell/src/resources/assets/js/appshell.standalone.js', 'public/js/appshell.js')
// Most probably you can delete the following 4 lines, if they're present:
.scripts([
        'public/js/app.js',
        'vendor/konekt/appshell/src/resources/assets/js/appshell.js'
], 'public/js/app.js')
//...
```

### Something Else

To go your own way, read the [Customizing The Admin UI Guide](customize-admin-ui.md) for more details
