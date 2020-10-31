# The Menu Component

The menu functionality is built on top of [Konekt Menu Component](https://github.com/artkonekt/menu).
The component is automatically loaded, is fully available (incl. the `Menu` facade).

AppShell creates a menu named **appshell** which is the main menu
component, and is available in views as `$appshellMenu`.

## Adding Items To AppShell Menu

```php
use Konekt\Menu\Facades\Menu;

class AppServiceProvider
{
    public function boot()
    {
        if ($menu = Menu::get('appshell')) {
            $menu->addItem('sales', __('Sales')); // <- New root level header
            $menu->addItem('funnels', __('Funnels'),
                ['route' => 'app.funnel.index'])
                 ->data('icon', 'funnels')
                 ->allowIfUserCan('list funnels');
            
            $stats = $menu->addItem('stats', __('Statistics')); // Root level group
            $stats->allowIfUserCan('view monthly revenues');

            // Add an item in the stats group
            $stats->addSubItem('monthly_revenue', __('Monthly Revenue'), ['route' => 'statistics.monthly_revenue.index'])
                  ->data('icon', 'chart')
                  ->activateOnUrls('/statistics/monthly_revenue/*')
                  ->allowIfUserCan('view monthly revenues');
        }
    }
}
```

---

**Next**: [Breadcrumbs &raquo;](breadcrumbs.md)
