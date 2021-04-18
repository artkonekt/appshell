# Widgets

Beginning with AppShell v2.3, rendering of views can happen with the help of widgets. Using of
widgets will be the fundamental paradigm shift of AppShell v3, and it's being introduced in v2 in
order to support the gradual upgrade.

## Widget Basics

Widgets are atomic UI components eg. text controls, checkboxes, badges, etc that are defined in a
frontend agnostic way. Each theme can implement their own variant of these widgets. As a consequence,
AppShell is no longer coupled with Bootstrap or any other frontend framework. Specific themes can
use any frontend framework they want as long as they implement the widgets.

The structure of widgets is defined in the backend, eg.: the user edit controller defines that it
wants to render a form that contains a text edit for the username, another for email, etc.

The widget will be rendered by the active theme. The backend based definition also gives the
opportunity for plugins to extend the predefined widget sets, with the most typical example to add
elements to an existing form.

## Data to Render

Widgets expect some data that they can render. Most of the time this is an eloquent model, or a
collection of models, but it can be an array, string, any kind of data.

The data has to be injected in the views, where you render the data.

**Controller**:

```php
use Konekt\AppShell\Widgets;

class UserController extends Controller
{
    public function index()
    {
        $tableDef = ['columns' => ['id', 'name', 'created_at']];
        return view('user.index', [
            'users' => User::all(),
            'table' => Widgets::make('table', $tableDef),            
        ]);
    }
}
```

**In the view**:

```blade
{!! $table->render($users) !!}
```

## UI Widget Files

Concrete widgets can be outsourced to files with `.widget.php`
extension.

The `.widget.php` files are plain PHP files, similar to the Laravel
config files and they need to return an array with 2 keys:

```php
return [
    'type' => 'table',     // the type id of the widget. mandatory
    'options' => [/*...*/] // the definition of the widgets eg. column definitions. optional
];
```

The code below will load the widget definition from the
`resources/widgets/invoice/index/table.widget.php` file:

```php  
$table = Widgets::load('invoice.index.table');
// or
$table = widget('invoice.index.table');
```

**resources/widgets/invoice/index/table.widget.php**:

```php
use Konekt\AppShell\Widgets\AppShellWidgets;

return [
    'type' => AppShellWidgets::TABLE,
    'options' => [
        'columns' => [
            'id',
            'number',
            'created_at',
            'is_paid' => [
                'title' => __('Payment'),
                'widget' => [
                    'type' => 'badge',
                    'color' => ['bool' => ['success', 'secondary']],
                    'text' => '$model.is_active',
                    'modifier' => sprintf('bool2text:%s,%s', __('paid'), __('outstanding'))
                ]
            ],
        ]
    ]
];
```

### Overriding Package UI Widgets

Similarly to [Laravel Views](https://laravel.com/docs/8.x/packages#overriding-package-views),
the UI Widgets defined in packages can be overridden in the host
applications.

When you use the `Widgets::load` method or the `widget()` helper,
AppShell actually checks two locations for your views: the application's
`resources/widgets/vendor` directory and the original directory in the package.  

So, using the `appshell` package as an example, AppShell will first
check if a custom version of the widget has been placed in the
`resources/widgets/vendor/appshell` directory by the developer. Then, if the
widget has not been customized, AppShell will load it from the package
UI directory.

## Built-in Widgets

AppShell comes with several predefined widgets:

- [Text](widget-text.md)
- [Link](widget-link.md)
- [Badge(s)](widget-badge.md)
- [MultiText](widget-multitext.md)
- [Date & Time](widget-datetime.md)
- [Table](widgets-table.md)
