# Breadcrumbs

Breadcrumbs are supported via the [Laravel Breadcrumbs](https://github.com/diglactic/laravel-breadcrumbs)
package.

## Define Breadcrumbs

Use the `Breadcrumbs` facade to define breadcrumbs:

```php
Breadcrumbs::for('home', function ($breadcrumbs) {
    $breadcrumbs->push(__('Home'), url('/'));
});

Breadcrumbs::for('app.order.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Orders'), route('app.order.index'));
});
```

### Loading Breadcrumbs With AppShell Helpers

If your application is built from [Concord Modules](https://konekt.dev/concord/1.8/modules), you
can use a very simple way to define and load breadcrumbs:

Add `breadcrumbs.php` to your module's `<module_root>/resources/routes/` folder:

```php
// Define breadcrumbs:
Breadcrumbs::for('app.product.index', function ($breadcrumbs) {
    // 
});
```

Add the `HasBreadcrumbs` trait to your module service provider and call the `loadBreadcrumbs()`
method on boot:

```php
class ModuleServiceProvider extends Konekt\Concord\BaseBoxServiceProvider
{
    use Konekt\AppShell\Breadcrumbs\HasBreadcrumbs;
    
    public function boot()
    {
        parent::boot();
        
        $this->loadBreadcrumbs();        
    }
}
```

This will load the breadcrumbs if breadcrumbs are enabled for the module.
Breadcrumbs will be rendered in the resulting AppShell pages.

## Disabling Breadcrumbs

It's possible to disable the breadcrumbs feature via AppShell configuration:

```php
// config/concord.php
return [
    'modules' => [
        Konekt\AppShell\Providers\ModuleServiceProvider::class => [
            'breadcrumbs' => false            
        ]
    ]
];
```

---

**Next**: [Search &raquo;](search.md)
