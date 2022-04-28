# Upgrading

## 2.x -> 3.0

Beginning with AppShell 3.0, the minimum requirements are:  

- PHP 8.0+
- Laravel 8.12+

### Vue Replaced With Alpinejs

The most important change of v3 is that Vue has been replaced with Alpinejs (3.10+).
It has several consequences:
1. You need to add Alpinejs to your application's frontend: `npm add alpinejs@3.10`
2. You can remove vue from your application if you no longer need it (`npm remove vue`)
3. If your AppShell modules contain vue code you may rewrite them for Alpine (usually it is fairly simple)
4. It's still OK to keep vuejs in your application if you need it

## 1.x -> 2.0

Beginning with AppShell 2.0, the minimum required PHP version is PHP 7.4, minimum Laravel is 6.0.

### Make Superuser Command

- The `appshell:super` artisan command has been renamed to `make:superuser`

### Themes

Due to comprehensive theming support, the layouts have changed, thus you have to replace the
followings in your application views:

1. Change `@extends('appshell::layouts.default')` to => `@extends('appshell::layouts.private')` 
2. Change `@extends('appshell::layouts.auth')` to => `@extends('appshell::layouts.public')` 

- The `getName` method in the Theme interface is now static

### Color Helper

The `semantic_color_to_hex()` method has been renamed to `theme_color()`.

It does the same thing, but takes the values from the current theme.

### Icons

It's not necessary, but if you want your app to use an icon theme other than
[ZMDI](https://zavoloklom.github.io/material-design-iconic-font/icons.html) then convert your icons
to use the `{!! icon('name') !!}` syntax in your views.

```blade
{{-- Old code --}}
<i class="zmdi zmdi-plus"></i>

{{-- New code, supporting icon themes --}}
{!! icon('+') !!}
``` 

If you want your app to support icon themes, then use the `ExtendsIconThemes` and/or
`RegistersEnumIcons` helper traits:

```php
// app/Providers/AppServiceProvider.php
class AppServiceProvider extends ServiceProvider
{
    use ExtendsIconThemes;

    // Define the $icons property in this structure:
    private array $icons = [
        'projects'  => [
            ZmdiIconTheme::ID        => 'folder-star',
            LineIconsTheme::ID       => 'folder',
            FontAwesomeIconTheme::ID => 'folder-open'
        ],
        'worklogs'  => [
            ZmdiIconTheme::ID        => 'collection-text',
            LineIconsTheme::ID       => 'indent-increase',
            FontAwesomeIconTheme::ID => 'receipt'
        ],
    ];
    
    public function boot()
    {
        $this->registerIconExtensions();
    }
}
```

### Enum Icon Mapping

This was an undocumented feature, so the likelihood you'll stumble upon this is very low.

The service `app('appshell.icon')` no longer exists, and it's class `EnumIconMapper` has been
converted to a static registry called `EnumIcons`.

**Old code:**

```php
$this->app['appshell.icon']->registerEnumIcons(
    IssueStatus::class,
    [
        IssueStatus::TODO        => 'circle-o', //with AppShell v1 icon name had to be a ZMDI icon
        IssueStatus::IN_PROGRESS => 'spinner',
        IssueStatus::DONE        => 'check-circle-u'
    ]
);
```

**New code:**

```php
EnumIcons::registerEnumIcons(
    IssueStatus::class,
    [
        IssueStatus::TODO        => 'todo',    // with AppShell v2, due to Icon Theme support,
        IssueStatus::IN_PROGRESS => 'spinner', // icon name has to be an abstract icon name
        IssueStatus::DONE        => 'check'
    ]
);
```

Also, the icon names have to be "abstract" icon names and not icon names specific to an icon set
like Font Awesome, ZMDI Material Icons, Line Icons, etc.

In blade views you can continue using the `enum_icon` helper:

```blade
@component(theme_widget('card_with_icon'), [
        'icon' => enum_icon($issue->status)
])

{{-- OR --}}

{!! icon(enum_icon($worklog->state)) !!}
```

See [Icon Themes Section](icon-themes.md) for more details.

### Assets

The configuration based assets feature has been removed.
Hence, entries under the `ui.assets` AppShell configuration node are no longer detected and
injected in the layout.

Use the blade based header and footer include partials in your application instead.

For more details, refer to the [Assets Documentation](assets.md). 

### UI Data

The `$appshell` object containing the UI config is no longer an `\stdClass` object but an instance
of `\Konekt\AppShell\Ui\UIConfig`. You can still use it's properties like `$appshell->name` or
`$appshell->url`.

### ACL & Resource Permissions

The resource name transformation in v1 was inconsistent between the `ResourcePermissions` class and
the ACL middleware in case the resource name consisted of two words like "issueType"/"issue_type".

In such cases the difference was the following:

- `ResourcePermissions` gave "list issue_types" for index action, whereas
- `AclMiddleware` gave "list issuetypes" for index action.
  
The mismatch came from the fact that AclMiddleware took the controller class name, removed the
`Controller` suffix and converted the rest of the name to lower case, ie:
`IssueTypeController` -> `IssueType` -> `issuetype`.

The `ResourcePermissions` class has been (unfortunately) widely used in migrations (bad practice).
In order to not to break them all, the `ResourcePermissions` class has been is kept in v2 as-is,
but it has been marked as deprecated.

In v2, `ResourcePermissions` has been replaced with `ResoucePermissionMapper` interface and its
default implementation, the `DefaultResourcePermissions` class. The ACL middleware is working with
the actual implementation of the `ResoucePermissionMapper` interface and is more consistent.

In case your code is directly using the `ResourcePermissions` class, replace it:

```php
//
// OLD CODE:
//
class SomeClass
{
    public function someMethod()
    {
        return ResourcePermissions::overrideResourcePlural('taxon', 'taxons');
    }
}
//
// NEW CODE (LET THE CONTAINER TO INJECT IT):
//
class SomeClass
{
    private $resoucePermissions;
    
    public function __construct(ResoucePermissionMapper $resoucePermissions)
    {
        $this->resoucePermissions = $resoucePermissions;
    }
        
    public function someMethod()
    {
        $this->resoucePermissions->overrideResourcePlural('taxon', 'taxons');
    }
}
//
// NEW CODE, ALTERNATIVE SOLUTION:
//
class SomeClass 
{        
    public function someMethod()
    {
        $resoucePermissions = app(ResoucePermissionMapper::class);
        $resoucePermissions->overrideResourcePlural('taxon', 'taxons');
    }
}
``` 

The resource name transformation for permissions has changed according to the followings:

| Original Resource Name | V1 Transformation                 | V2 Transformation | Compatible |
|:-----------------------|:----------------------------------|:------------------|:-----------|
| `product`              | `products`                        | `products`        | ✔          |
| `Product`              | `products`                        | `products`        | ✔          |
| `product_type`         | `product_types` or `producttypes` | `product types`   | ❌          |
| `productType`          | `productTypes` or `producttypes`  | `product types`   | ❌          |
| `product-type`         | `product-types` or `producttypes` | `product types`   | ❌          |
| `ProductType`          | `ProductTypes` or `producttypes`  | `product types`   | ❌          |

The conventional way of creating resources as of 2.x is:

```php
// Route Definition
Route::resource('product-type', 'ProductTypeController')
    ->parameters(['product-type' => 'productType']);

// Controller action:
public function show (ProductType $productType) {/*...*/}

// Permission:
$user->can('view product types');
```

#### Migrate Resource Names

For simple resource names like `product`, `issue` or `category` there's nothing to be done.
If you have resources that consists of multiple words like `product type`, `issue_type`, etc you have
to:

1. Rename the permissions in the table (create migrations for that!)
2. Rename the permission names in code occurrences

**Example Migration:**

```php
class UpdatePermissionsToAppshellV2 extends Migration
{
    private $permissionsToMigrate = [
        'list issue_types'   => 'list issue types',
        'create issue_types' => 'create issue types',
        'view issue_types'   => 'view issue types',
        'edit issue_types'   => 'edit issue types',
        'delete issue_types' => 'delete issue types',
    ];

    public function up()
    {
        foreach ($this->permissionsToMigrate as $old => $new) {
            Permission::findByName($old)->update(['name' => $new]);
        }
    }

    public function down()
    {
        foreach ($this->permissionsToMigrate as $old => $new) {
            Permission::findByName($new)->update(['name' => $old]);
        }
    }
}
```

## 0.9 -> 1.0

## AppShell Scripts

AppShell's default html layout after v1.0 looks for the `/js/appshell.js` script.

Also, beginning with v1.0 it's possible to [configure](customize-admin-ui.md)
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

---

**Next**: [Admin Panel &raquo;](admin-panel.md)
